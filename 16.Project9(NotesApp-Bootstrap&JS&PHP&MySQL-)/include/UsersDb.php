<?php
    class UsersDb extends MySQLi {
        //variables
        public $errors = array();
        //constants
        const missingUsername = "Please enter an username!";
        const missingEmail = "Please enter an email!";
        const missingPassword = "Please enter a password!";
        const invalidEmail = "Please enter a valid email!";
        const weakPassword = "Password is too weak! Please enter a password with at least one digit, one capital letter and a special symbol!";
        const distinctPasswords = "Passwords don't match!";
        const hashingError = "There was an error while hashing sensitive data.";
        const usernameOrEmailExists = "Username or email already exist in our database.";
        const mailSendingError = "There was an error sending confirmation email.";
        const activationError = "An error has occured while activating your account.";
        const emailNotActivated = "Your account is not activated.";
        const loginFailed = "Login failed. Wrong email or password.";
        const cookieSetError = "An error has occured while accessing your cookie file.";
        const securityAlert = "There is a security issue. Be careful, maybe someone tries to steal your account!";
        const emailNotInDatabase = "Email not in our database.";
        const expiredLink = "Reset link has expired.";
        const forgotPasswordRequestExist = "There is already a pending request to reset password on this account.";
        const userNotLoggedIn = "User not logged in!";
        const usernameExist = "Username already exist in our database.";
        const newEmailExist = "This new email already exist in our database.";
        const wrongPassword = "Incorrect password!";
        //new methods
        //static methods
        public static function logout() {
            session_unset();
            setcookie("rememberMe", "", time() - 100);
            header("Location: index.php");
        }

        //public
        public function __construct(string $hostname, string $username, string $password, string $database) {
            parent::__construct($hostname, $username, $password, $database);
        }

        public function signup($username, $email, $password1, $password2, $activationFile) {
            $this->clearErrors();

            //check user input errors
            $username = $this->checkUsername($username);
            $email = $this->checkEmail($email);
            if (empty($password1)) {
                $this->addError(self::missingPassword);
            } else {
                if (strlen($password1) < 6 || !preg_match("/[A-Z]/", $password1) ||
                    !preg_match("/[0-9]/", $password1) || !preg_match("/[^A-Za-z0-9\s]/", $password1)) {
                        $this->addError(self::weakPassword);
                } else {
                    if (strcmp($password1, $password2) !== 0) {
                        $this->addError(self::distinctPasswords);
                    }
                }
            }

            //return errors
            if ($this->existErrors()) {
                return;
            }

            $this->checkUsernameOrEmailExists($username, $email);
            if ($this->existErrors()) {
                return;
            }

            $activationKey = $this->insertUserData($username, $email, $password1);
            if ($this->existErrors()) {
                return;
            }

            //send activation email
            $urlEmail = urlencode($email);
            $message = "To confirm your account please click on the following link: http://".$_SERVER["HTTP_HOST"].dirname($_SERVER["PHP_SELF"])."/$activationFile?key=$activationKey&email=$urlEmail";
            if (!mail($email, "Confirm your account", $message)) {
                $this->addError(self::mailSendingError);
                return;
            }
        }

        public function activateAccount($activationKey, $email) {
            $this->clearErrors();

            $stmt = $this->prepare("SELECT * FROM Users WHERE Email = ? AND Activation = ?");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("ss", $email, $activationKey)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->store_result()) {
                $this->addError($stmt->error);
                return;
            }
            if ($stmt->num_rows !== 1) {
                $this->addError(self::activationError);
                return;
            }
            $stmt->free_result();
            $stmt->close();

            $stmt = $this->prepare("UPDATE Users SET Activation = 'active' WHERE Email = ?");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("s", $email)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            $stmt->close();
        }

        public function login($email, $password, $rememberMe) {
            $this->clearErrors();

            $email = $this->checkEmail($email);
            $password = $this->checkPassword($password);
            if ($this->existErrors()) return;

            $this->getDataFromUsersOnEmail($id, $username, $passwordHash, $activation, $changeActivation, $numRows,  $email);
            if ($this->existErrors()) return;

            if ($numRows === 0) {
                $this->addError(self::emailNotInDatabase);
                return;
            }
            if ($activation !== "active") {
                $this->addError(self::emailNotActivated);
                return;
            }
            if (!password_verify($password, $passwordHash)) {
                $this->addError(self::loginFailed);
                return;
            }

            //no login errors
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            //user logged in

            //remember me option ?
            if ($rememberMe) {
                $this->removeExpiredFromRememberMe();
                if ($this->existErrors()) return;
                $this->generateRememberMe();
                if ($this->existErrors()) return;
            }

        }

        public function remember() {
            $this->clearErrors();

            if (empty($_COOKIE["rememberMe"]) || !preg_match("/([0-9a-fA-F])+,([0-9a-fA-F])+/", $_COOKIE["rememberMe"])) {
                return false;
            }

            list($identifier, $token) = explode(",", $_COOKIE["rememberMe"]);
            $identifier = filter_var($identifier, FILTER_SANITIZE_STRING);
            $token = filter_var($token, FILTER_SANITIZE_STRING);

            $stmt = $this->prepare("SELECT UserId, Token, ExpireTime FROM RememberMe WHERE Identifier = ?");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("s", $identifier)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->store_result()) {
                $this->addError($stmt->error);
                return;
            }
            if ($stmt->num_rows === 0) {
                $this->addError(self::securityAlert);
                return;
            }
            if (!$stmt->bind_result($userId, $tokenHash, $expireTime)) {
                $this->addError($stmt->error);
                return;
            }
            if ($stmt->fetch() === false) {
                $this->addError($stmt->error);
                return;
            }
            $stmt->free_result();
            $stmt->close();

            if (!password_verify($token, $tokenHash)) {
                $stmt = $this->prepare("DELETE FROM RememberMe WHERE Identifier = ?");
                if (!$stmt) {
                    $this->addError($stmt->error);
                    return;
                }
                if (!$stmt->bind_param("s", $identifier)) {
                    $this->addError($stmt->error);
                    return;
                }
                if (!$stmt->execute()) {
                    $this->addError($stmt->error);
                    return;
                }
                $stmt->close();
                $this->addError(self::securityAlert);
                return;
            }

            if (time() > $expireTime) {
                return false;
            }

            //no errors; so, log in the user
            if (!($result = $this->query("SELECT Username, Email FROM Users WHERE Id = $userId"))) {
                $this->addError($this->error);
                return;
            }
            $row = $result->fetch_assoc();
            $_SESSION['id'] = $userId;
            $_SESSION['username'] = $row["Username"];
            $_SESSION['email'] = $row["Email"];

            $this->generateRememberMe();
            if ($this->existErrors()) return;

            return true;
        }

        public function forgotPassword($email, $resetPasswordFile) {
            $this->clearErrors();

            $email = $this->checkEmail($email);

            $this->removeExpiredFromForgotPassword();
            if ($this->existErrors()) {
                return;
            }

            $this->getDataFromUsersOnEmail($userId, $username, $passwordHash, $activation, $changeActivation, $numRows,  $email);
            if ($this->existErrors()) {
                return;
            }
            if ($numRows === 0) {
                $this->addError(self::emailNotInDatabase);
                return;
            }
            if ($activation !== "active") {
                $this->addError(self::emailNotActivated);
                return;
            }

            // if (!($result = $this->query("SELECT * FROM ForgotPassword WHERE UserId = $userId"))) {
            //     $this->addError($this->error);
            //     return;
            // }
            // if ($result->num_rows !== 0) {
            //     $this->addError(self::forgotPasswordRequestExist);
            //     return;
            // }

            $resetKey = bin2hex(random_bytes(16));
            $expireTime = time() + 24*60*60;
            $status = "pending";
            if (!$this->query("INSERT INTO ForgotPassword (UserId, ResetKey, ExpireTime, Status) VALUES ($userId, '$resetKey', $expireTime, '$status')")) {
                $this->addError($this->error);
                return;
            }

            $urlEmail = urlencode($email);
            $message = "To reset your password please click on the following link: http://".$_SERVER["HTTP_HOST"].dirname($_SERVER["PHP_SELF"])."/$resetPasswordFile?key=$resetKey&email=$urlEmail";
            if (!mail($email, "Reset password", $message)) {
                $this->addError(self::mailSendingError);
                return;
            }
        }

        public function validateForgotPassword($resetPasswordKey, $email) {
            $this->clearErrors();

            $this->getDataFromUsersOnEmail($userId, $username, $passwordHash, $activation, $changeActivation, $numRows,  $email);
            if ($this->existErrors()) {
                return;
            }
            if ($numRows === 0) {
                $this->addError(self::emailNotInDatabase);
                return;
            }
            if ($activation !== "active") {
                $this->addError(self::emailNotActivated);
                return;
            }

            $this->getDataFromForgotPasswordOnUserIdAndResetKey($expireTime, $status, $numRows, $userId, $resetPasswordKey);
            if ($this->existErrors()) return;
            if ($numRows === 0) {
                $this->addError(self::securityAlert);
                return;
            }

            if ($status !== "pending") {
                $this->addError(self::securityAlert);
                return;
            }
            if ($expireTime < time()) {
                $this->addError(self::expiredLink);
                return;
            }

            //no errors
            $stmt = $this->prepare("UPDATE ForgotPassword SET Status = 'used' WHERE UserId = ?");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("i", $userId)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            $stmt->close();
            return true;
        }

        public function resetPassword($resetPasswordKey, $email, $newPassword1, $newPassword2) {
            $this->clearErrors();

            $email = $this->checkEmail($email);
            if (empty($newPassword1)) {
                $this->addError(self::missingPassword);
            } else {
                if (strlen($newPassword1) < 6 || !preg_match("/[A-Z]/", $newPassword1) ||
                    !preg_match("/[0-9]/", $newPassword1) || !preg_match("/[^A-Za-z0-9\s]/", $newPassword1)) {
                        $this->addError(self::weakPassword);
                } else {
                    if (strcmp($newPassword1, $newPassword2) !== 0) {
                        $this->addError(self::distinctPasswords);
                    }
                }
            }
            if ($this->existErrors()) return;

            $this->getDataFromUsersOnEmail($userId, $username, $passwordHash, $activation, $changeActivation, $numRows, $email);
            if ($this->existErrors()) return;
            if ($numRows === 0) {
                $this->addError(self::emailNotInDatabase);
                return;
            }
            if ($activation !== "active") {
                $this->addError(self::emailNotActivated);
                return;
            }

            $this->getDataFromForgotPasswordOnUserIdAndResetKey($expireTime, $status, $numRows, $userId, $resetPasswordKey);
            if ($this->existErrors()) return;
            if ($numRows === 0) {
                $this->addError(self::securityAlert);
                return;
            }
            if ($status !== "used") {
                $this->addError(self::securityAlert);
                return;
            }
            if ($expireTime < time()) {
                $this->addError(self::expiredLink);
                return;
            }

            //no errors
            $stmt = $this->prepare("DELETE FROM ForgotPassword WHERE UserId = ?");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("i", $userId)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            $stmt->close();

            if (!($password = password_hash($newPassword1, PASSWORD_DEFAULT))) {
                $this->addError(self::hashingError);
                return;
            }
            $stmt = $this->prepare("UPDATE Users SET Password = ? WHERE Id = ?");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("si", $password, $userId)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return false;
            }
            $stmt->close();

            return true;
        }

        public function changeUsername($id, $newUsername) {
            $this->clearErrors();

            if (empty($_SESSION["id"])) {
                $this->addError(self::userNotLoggedIn);
                return;
            }

            $newUsername = $this->checkUsername($newUsername);
            if ($this->existErrors()) return;

            $stmt = $this->prepare("SELECT * FROM Users WHERE Username = ?");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("s", $newUsername)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->store_result()) {
                $this->addError($stmt->error);
                return;
            }
            if ($stmt->num_rows !== 0) {
                $this->addError(self::usernameExist);
                return;
            }
            $stmt->free_result();
            $stmt->close();

            $stmt = $this->prepare("UPDATE Users SET Username = ? WHERE Id = ?");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("si", $newUsername, $id)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            $stmt->close();

            $_SESSION["username"] = $newUsername;
        }

        public function requestChangeEmail($newEmail, $changeEmailFile) {
            $this->clearErrors();

            if (empty($_SESSION["id"])) {
                $this->addError(self::userNotLoggedIn);
                return;
            }
            $userId = $_SESSION["id"];
            $email = $_SESSION["email"];

            $newEmail = $this->checkEmail($newEmail);
            if ($this->existErrors()) return;

            $this->getDataFromUsersOnEmail($id, $username, $passwordHash, $activation, $changeActivation, $numRows, $newEmail);
            if ($this->existErrors()) return;
            if ($numRows !== 0) {
                $this->addError(self::newEmailExist);
                return;
            }

            $changeEmailKey = bin2hex(random_bytes(16));
            if (!$this->query("UPDATE Users SET ChangeActivation = '$changeEmailKey' WHERE Id = $userId")) {
                $this->addError($this->error);
                return;
            }

            $urlNewEmail = urlencode($newEmail);
            $urlEmail = urlencode($email);
            $message = "To change your email please click on the following link: http://".$_SERVER["HTTP_HOST"].dirname($_SERVER["PHP_SELF"])."/$changeEmailFile?key=$changeEmailKey&newEmail=$urlNewEmail&email=$urlEmail";
            if (!mail($newEmail, "Change email", $message)) {
                $this->addError(self::mailSendingError);
                return;
            }
        }

        public function changeEmail($changeEmailKey, $newEmail, $oldEmail) {
            $this->clearErrors();

            $newEmail = $this->checkEmail($newEmail);
            if ($this->existErrors()) return;

            $this->getDataFromUsersOnEmail($id, $username, $passwordHash, $activation, $changeActivation, $numRows, $newEmail);
            if ($this->existErrors()) return;
            if ($numRows !== 0) {
                $this->addError(self::newEmailExist);
                return;
            }

            $this->getDataFromUsersOnEmail($id, $username, $passwordHash, $activation, $changeActivation, $numRows, $oldEmail);
            if ($this->existErrors()) return;
            if ($numRows === 0) {
                $this->addError(self::emailNotInDatabase);
                return;
            }
            if ($activation !== "active") {
                $this->addError(self::emailNotActivated);
                return;
            }
            if ($changeActivation !== $changeEmailKey) {
                $this->addError(self::securityAlert);
                return;
            }

            //no errors, change email
            $stmt = $this->prepare("UPDATE Users SET Email = ? , ChangeActivation = '0' WHERE Email = ?");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("ss", $newEmail, $oldEmail)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            $stmt->close();

            if (!empty($_SESSION["id"])) {
                $_SESSION["email"] = $newEmail;
            }
        }

        public function changePassword($oldPassword, $newPassword1, $newPassword2) {
            $this->clearErrors();

            if (empty($_SESSION["id"])) {
                $this->addError(self::userNotLoggedIn);
                return;
            }
            $id = $_SESSION["id"];

            $oldPassword = $this->checkPassword($oldPassword);
            if ($this->existErrors()) return;

            $this->getDataFromUsersOnId($username, $email, $passwordHash, $activation, $numRows, $id);
            if ($this->existErrors()) return;
            if ($numRows === 0) {
                $this->addError(self::securityAlert);
                return;
            }
            if ($activation !== "active") {
                $this->addError(self::emailNotActivated);
                return;
            }
            if (!password_verify($oldPassword, $passwordHash)) {
                $this->addError(self::wrongPassword);
                return;
            }

            if (empty($newPassword1)) {
                $this->addError(self::missingPassword);
            } else {
                if (strlen($newPassword1) < 6 || !preg_match("/[A-Z]/", $newPassword1) ||
                    !preg_match("/[0-9]/", $newPassword1) || !preg_match("/[^A-Za-z0-9\s]/", $newPassword1)) {
                        $this->addError(self::weakPassword);
                } else {
                    if (strcmp($newPassword1, $newPassword2) !== 0) {
                        $this->addError(self::distinctPasswords);
                    }
                }
            }
            if ($this->existErrors()) return;

            if (!($password = password_hash($newPassword1, PASSWORD_DEFAULT))) {
                $this->addError(self::hashingError);
                return;
            }

            if (!($result = $this->query("UPDATE Users SET Password = '$password' WHERE Id = $id"))) {
                $this->addError($this->error);
                return;
            }
        }

        public function createNote($userId) {
            $this->clearErrors();

            $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
            $t = time();
            $stmt = $this->prepare("INSERT INTO Notes (UserId, Note, LastModified) VALUES (?, '', ?)");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("ii", $userId, $t)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            $noteId = $stmt->insert_id;
            $stmt->close();
            return $noteId;
        }

        public function deleteNote($noteId) {
            $this->clearErrors();

            $noteId = filter_var($noteId, FILTER_SANITIZE_NUMBER_INT);
            $stmt = $this->prepare("DELETE FROM Notes WHERE Id = ?");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("i", $noteId)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            $stmt->close();
        }

        public function updateNote($noteId, $newNote) {
            $this->clearErrors();

            $noteId = filter_var($noteId, FILTER_SANITIZE_NUMBER_INT);
            $newNote = filter_var($newNote, FILTER_SANITIZE_STRING);
            $t = time();
            $stmt = $this->prepare("UPDATE Notes SET Note = ? , LastModified = ? WHERE Id = ?");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("sii", $newNote, $t, $noteId)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            $stmt->close();
        }

        public function deleteEmptyNotes($userId) {
            $this->clearErrors();

            $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
            $stmt = $this->prepare("DELETE FROM Notes WHERE UserId = ? AND Note = ''");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("i", $userId)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            $stmt->close();
        }
        public function getNotes($userId, $timeOffsetMinutes) {
            $this->clearErrors();

            $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
            $stmt = $this->prepare("SELECT Id, Note, LastModified FROM Notes WHERE UserId = ? ORDER BY LastModified DESC");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("i", $userId)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->store_result()) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_result($noteId, $note, $lastModified)) {
                $this->addError($stmt->error);
                return;
            }
            $result = "";
            while ($stmt->fetch()) {
                $dateTime = gmdate("H:i:s d-m-Y", $lastModified-($timeOffsetMinutes*60));
                $row = "<div class='row noteRow' id='$noteId'>
                            <div class='col-xs-5 col-sm-3 noteDelete'>
                                <button class='btn btn-danger btn-lg deleteBtn'>delete</button>
                            </div>
                            <div class='col-xs-7 col-sm-9 noteContainer'>
                                <div class='noteContent'>
                                    <div class='noteText'>$note</div>
                                    <div class='noteTime'>$dateTime</div>
                                </div>
                            </div>
                        </div>";
                $result .= $row;
            }
            $stmt->free_result();
            $stmt->close();

            return $result;
        }

        public function existErrors() : bool {
            if (count($this->errors) === 0) {
                return false;
            } else {
                return true;
            }
        }

        //protected
        protected function clearErrors() {
            array_splice($this->errors, 0);
        }

        protected function addError($error) {
            array_push($this->errors, $error);
        }
        protected function generateRememberMe() {
            $identifier = bin2hex(random_bytes(8));//16 bytes
            $token = bin2hex(random_bytes(10));//20 bytes
            $expire = time() + 15*24*60*60;//15 days later
            if (!setcookie("rememberMe", "$identifier,$token", $expire)) {
                $this->addError(self::cookieSetError);
                return;
            }
            $token = password_hash($token, PASSWORD_DEFAULT);
            //check if token was hashed succesfully
            if (!$token) {
                $this->addError(self::hashingError);
                return;
            }

            $id = $_SESSION['id'];
            //if user already in remember me table, delete all records with his id
            if (!$this->query("DELETE FROM RememberMe WHERE UserId = $id")) {
                $this->addError($this->error);
                return;
            }

            if (!$this->query("INSERT INTO RememberMe (UserId, Identifier, Token, ExpireTime) VALUES ($id, '$identifier', '$token', $expire)")) {
                $this->addError($this->error);
                return;
            }
        }
        protected function checkUsername($username) {
            if (empty($username)) {
                $this->addError(self::missingUsername);
            } else {
                $username = filter_var($username, FILTER_SANITIZE_STRING);
                return $username;
            }
        }
        protected function checkEmail($email) {
            if (empty($email)) {
                $this->addError(self::missingEmail);
            } else {
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->addError(self::invalidEmail);
                } else {
                    return $email;
                }
            }
        }
        protected function checkPassword($password) {
            if (empty($password)) {
                $this->addError(self::missingPassword);
            } else {
                return $password;
            }
        }
        protected function checkUsernameOrEmailExists($username, $email) {
            $stmt = $this->prepare("SELECT * FROM Users WHERE Username = ? OR Email = ?");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("ss", $username, $email)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->store_result()) {
                $this->addError($stmt->error);
                return;
            }
            if ($stmt->num_rows > 0) {
                $this->addError(self::usernameOrEmailExists);
                return true;
            }
            $stmt->free_result();
            $stmt->close();
            return false;
        }
        protected function insertUserData($username, $email, $password) {
            if (!($password = password_hash($password, PASSWORD_DEFAULT))) {
                $this->addError(self::hashingError);
                return;
            }
            $activationKey = bin2hex(random_bytes(16));
            $stmt = $this->prepare("INSERT INTO Users (Username, Email, Password, Activation, ChangeActivation) VALUES (?, ?, ?, ?, '0')");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("ssss", $username, $email, $password, $activationKey)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return false;
            }
            $stmt->close();
            return $activationKey;
        }
        protected function getDataFromUsersOnEmail(&$id, &$username, &$passwordHash, &$activation, &$changeActivation, &$numRows, $email) {
            $stmt = $this->prepare("SELECT Id, Username, Password, Activation, ChangeActivation FROM Users WHERE Email = ?");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("s", $email)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->store_result()) {
                $this->addError($stmt->error);
                return;
            }
            $numRows = $stmt->num_rows;
            if (!$stmt->bind_result($id, $username, $passwordHash, $activation, $changeActivation)) {
                $this->addError($stmt->error);
                return;
            }
            if ($stmt->fetch() === false) {
                $this->addError($stmt->error);
                return;
            }
            $stmt->free_result();
            $stmt->close();
        }
        protected function getDataFromUsersOnId(&$username, &$email, &$passwordHash, &$activation, &$numRows, $id) {
            $stmt = $this->prepare("SELECT Username, Email, Password, Activation FROM Users WHERE Id = ?");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("i", $id)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->store_result()) {
                $this->addError($stmt->error);
                return;
            }
            $numRows = $stmt->num_rows;
            if (!$stmt->bind_result($username, $email, $passwordHash, $activation)) {
                $this->addError($stmt->error);
                return;
            }
            if ($stmt->fetch() === false) {
                $this->addError($stmt->error);
                return;
            }
            $stmt->free_result();
            $stmt->close();
        }
        protected function removeExpiredFromRememberMe() {
            $t = time();

            if (!$this->query("DELETE FROM RememberMe WHERE ExpireTime < $t")) {
                $this->addError($this->error);
                return;
            }
        }
        protected function removeExpiredFromForgotPassword() {
            $t = time();
            if (!$this->query("DELETE FROM ForgotPassword WHERE ExpireTime < $t")) {
                $this->addError($this->error);
                return;
            }
        }
        protected function getDataFromForgotPasswordOnUserIdAndResetKey(&$expireTime, &$status, &$numRows, $userId, $resetPasswordKey) {
            $stmt = $this->prepare("SELECT ExpireTime, Status FROM ForgotPassword WHERE UserId = ? AND ResetKey = ?");
            if (!$stmt) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->bind_param("is", $userId, $resetPasswordKey)) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->execute()) {
                $this->addError($stmt->error);
                return;
            }
            if (!$stmt->store_result()) {
                $this->addError($stmt->error);
                return;
            }
            $numRows = $stmt->num_rows;
            if (!$stmt->bind_result($expireTime, $status)) {
                $this->addError($stmt->error);
                return;
            }
            if ($stmt->fetch() === false) {
                $this->addError($stmt->error);
                return;
            }
            $stmt->free_result();
            $stmt->close();
        }
    }
?>
