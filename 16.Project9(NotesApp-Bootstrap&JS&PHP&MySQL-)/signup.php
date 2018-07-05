<?php
    ob_start();
    session_start();
    require_once("include/data.php");
    require_once("include/UsersDb.php");

    $users = new UsersDb(HOSTNAME, USERNAME, PASSWORD, DATABASE);

    $users->signup($_POST["username"], $_POST["email"], $_POST["password"], $_POST["passwordConfirm"], "activate-account.php");

    if ($users->existErrors()) {
        $result = "<div class='alert alert-danger'><strong>";
        foreach ($users->errors as $error) {
            $result .= "<p>$error</p>";
        }
        $result .= "</strong></div>";
    } else {
        $result = "<div class='alert alert-success'><strong>Registration succesful! Please check your email to activate your account!</strong></div>";
    }

    echo $result;

    ob_flush();
?>
