<?php
    ob_start();
    session_start();
    require_once("include/data.php");
    require_once("include/UsersDb.php");

    $users = new UsersDb(HOSTNAME, USERNAME, PASSWORD, DATABASE);

    $users->requestChangeEmail($_POST["newEmail"], "change-email.php");

    if ($users->existErrors()) {
        $result = "<div class='alert alert-danger'><strong>";
        foreach ($users->errors as $error) {
            $result .= "<p>$error</p>";
        }
        $result .= "</strong></div>";
    } else {
        $result = "<div class='alert alert-success'><strong>A confirmation link was sent to your new email. Please click on it in order to change your email.</strong></div>";
    }

    echo $result;

    ob_flush();
?>
