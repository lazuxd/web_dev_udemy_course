<?php
    ob_start();
    session_start();
    require_once("include/data.php");
    require_once("include/UsersDb.php");

    $users = new UsersDb(HOSTNAME, USERNAME, PASSWORD, DATABASE);

    $users->forgotPassword($_POST["email"], "reset-password.php");

    if ($users->existErrors()) {
        $result = "<div class='alert alert-danger'><strong>";
        foreach ($users->errors as $error) {
            $result .= "<p>$error</p>";
        }
        $result .= "</strong></div>";
    } else {
        $result = "<div class='alert alert-success'><strong>Request submitted successfully! A confirmation email was send to your inbox.</strong></div>";
    }

    echo $result;

    ob_flush();
?>
