<?php
    ob_start();
    session_start();
    require_once("include/data.php");
    require_once("include/UsersDb.php");

    $users = new UsersDb(HOSTNAME, USERNAME, PASSWORD, DATABASE);

    $userId = $_POST["userId"];
    $timeOffsetMinutes = $_POST['timeOffsetMinutes'];
    $users->deleteEmptyNotes($userId);

    if ($users->existErrors()) {
        $result = "<div class='alert alert-danger'><strong>";
        foreach ($users->errors as $error) {
            $result .= "<p>$error</p>";
        }
        $result .= "</strong></div>";
    } else {
        $result = $users->getNotes($userId, $timeOffsetMinutes);
        if ($users->existErrors()) {
            $result = "<div class='alert alert-danger'><strong>";
            foreach ($users->errors as $error) {
                $result .= "<p>$error</p>";
            }
            $result .= "</strong></div>";
        } elseif ($result === "") {
            $result = "<div class='alert alert-warning'><strong>There are no notes yet.</strong></div>";
        }
    }

    echo $result;
    $users->close();

    ob_flush();
?>
