<?php
    ob_start();
    session_start();
    require_once("include/data.php");
    require_once("include/UsersDb.php");

    $users = new UsersDb(HOSTNAME, USERNAME, PASSWORD, DATABASE);

    $noteId = $users->createNote($_POST["userId"]);

    if ($users->existErrors()) {
        $result = "<div class='alert alert-danger'><strong>";
        foreach ($users->errors as $error) {
            $result .= "<p>$error</p>";
        }
        $result .= "</strong></div>";
    } else {
        $result = $noteId;
    }

    echo $result;

    ob_flush();
?>
