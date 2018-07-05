<?php
    ob_start();
    session_start();
    require_once("include/data.php");
    require_once("include/UsersDb.php");

    $users = new UsersDb(HOSTNAME, USERNAME, PASSWORD, DATABASE);

    $users->changePassword($_POST["currentPassword"], $_POST["newPassword1"], $_POST["newPassword2"]);

    if ($users->existErrors()) {
        $result = "<div class='alert alert-danger'><strong>";
        foreach ($users->errors as $error) {
            $result .= "<p>$error</p>";
        }
        $result .= "</strong></div>";
    } else {
        $result = "<div class='alert alert-success'><strong>Your password was changed successfully!</strong></div>";
    }

    echo $result;

    ob_flush();
?>
