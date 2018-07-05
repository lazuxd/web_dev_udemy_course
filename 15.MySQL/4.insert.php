<?php
function errorHandler($errno, $errstr, $errfile, $errline, $errcontext) {
    $logStr = "<p><strong>Error</strong> no. $errno<br/>In $errfile at $errline<br/>Context: ".print_r($errcontext, true)."<br/>Error message: $errstr</p>";
    echo $logStr;
    error_log($logStr, 1, "dorianlazar81@gmail.com", "Content-type: text/html");
    $fileName = "logs/".date("d-m-Y").".log";
    str_replace("<br/>", "\n", $logStr);
    $logStr = filter_var($logStr, FILTER_SANITIZE_STRING);
    if (!file_exists($fileName)) {
        $h = fopen($fileName, "w");
        fclose($h);
    }
    error_log($logStr, 3, $fileName);
}
set_error_handler("errorHandler");
require "secrets.php";
ob_start();
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <title>Insert</title>

        <style>
            .upload {
                border: 1px solid #4009b7;
                border-radius: 15px;
                margin-top: 30px;
                padding-bottom: 15px;
            }
            .upload h1 {
                color: #4009b7;
            }
            #file {
                height: auto;
            }
        </style>

    </head>
    <body>

        <?php require "19a.header.php"; ?>

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-offset-1 col-sm-10 upload">
                    <h1>Insert</h1>

                    <?php
                        if (isset($_POST["submit"])) {
                            //data
                            $FirstName = $_POST["FirstName"];
                            $LastName = $_POST["LastName"];
                            $Email = $_POST["Email"];
                            $Password = $_POST["Password"];
                            //errors
                            $missingFirstName = "<p>Please enter your first name!</p>";
                            $missingLastName = "<p>Please enter your last name!</p>";
                            $missingEmail = "<p>Please enter your email!</p>";
                            $missingPassword = "<p>Please enter your password!</p>";
                            $invalidEmail = "<p>Please enter a valid email!</p>";

                            $errors = "";
                            $result = "";

                            if (!$FirstName) {
                                $errors .= $missingFirstName;
                            } else {
                                $FirstName = filter_var($FirstName, FILTER_SANITIZE_STRING);
                            }
                            if (!$LastName) {
                                $errors .= $missingLastName;
                            } else {
                                $LastName = filter_var($LastName, FILTER_SANITIZE_STRING);
                            }
                            if (!$Email) {
                                $errors .= $missingEmail;
                            } else {
                                $Email = filter_var($Email, FILTER_SANITIZE_EMAIL);
                                if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                                    $errors .= $invalidEmail;
                                }
                            }
                            if (!$Password) {
                                $errors .= $missingPassword;
                            } else {
                                $Password = password_hash($Password, PASSWORD_DEFAULT);
                            }

                            if ($errors != "") {
                                $result = "<div class='alert alert-danger'><strong>$errors</strong></div>";
                            } else {
                                $link = @new mysqli(HOSTNAME, USERNAME, PASSWORD, "Users");
                                if ($link->connect_errno > 0) {
                                    $result = "<div class='alert alert-danger'><strong>Unable to connect to database: ".$link->connect_error."</strong></div>";
                                } else {
                                    $stmt = $link->prepare("INSERT INTO Users (FirstName, LastName, Email, Password) VALUES (?, ?, ?, ?);");
                                    $stmt->bind_param("ssss", $FirstName, $LastName, $Email, $Password);
                                    if($stmt->execute()) {
                                        $result = "<div class='alert alert-success'><strong>Data inserted succesfully.</strong></div>";
                                    } else {
                                        $result = "<div class='alert alert-danger'><strong>Unable to insert data: ".$stmt->error."</strong></div>";
                                    }
                                    $stmt->close();
                                    $link->close();
                                }
                            }
                            echo $result;
                        }
                    ?>

                    <form method="post">
                        <div class="form-group">
                            <label for="FirstName">First Name:</label>
                            <input type="text" name="FirstName" id="FirstName" placeholder="First Name" maxlength="20" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="LastName">Last Name:</label>
                            <input type="text" name="LastName" id="LastName" placeholder="Last Name" maxlength="20" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="Email">Email:</label>
                            <input type="email" name="Email" id="Email" placeholder="Email" maxlength="30" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="Password">Password:</label>
                            <input type="password" name="Password" id="Password" placeholder="Password" maxlength="30" class="form-control"/>
                        </div>
                        <input type="submit" name="submit" id="submit" value="Send data" class="btn btn-success btn-lg"/>
                    </form>

        </div>

        <?php require "19b.footer.php"; ?>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script>

        </script>
    </body>
</html>
<?php ob_flush(); ?>
