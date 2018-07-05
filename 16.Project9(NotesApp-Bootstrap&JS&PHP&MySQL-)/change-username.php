<?php
    ob_start();
    session_start();
    require_once("include/data.php");
    require_once("include/UsersDb.php");

    $users = new UsersDb(HOSTNAME, USERNAME, PASSWORD, DATABASE);

    $users->changeUsername($_SESSION["id"], $_POST["newUsername"]);

    $json = "{ \"html\": \"";
    if ($users->existErrors()) {
        $result = "<div class='alert alert-danger'><strong>";
        foreach ($users->errors as $error) {
            $result .= "<p>$error</p>";
        }
        $result .= "</strong></div>";
        $json .= "$result\", \"success\": false, \"username\": \"".$_SESSION["username"]."\" }";
    } else {
        $result = "<div class='alert alert-success'><strong>Your username was changed successfully!</strong></div>";
        $json .= "$result\", \"success\": true, \"username\": \"".$_SESSION["username"]."\" }";
    }

    echo $json;

    ob_flush();
?>
