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

        <title>Delete</title>

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
                    <h1>Delete</h1>

                    <?php

                        $link = @new mysqli(HOSTNAME, USERNAME, PASSWORD, "Users");
                        $output = "";
                        if ($link->connect_errno > 0) {
                             $output = "<div class='alert alert-danger'><strong>Unable to connect to database: ".$link->connect_error."</strong></div>";
                        } else {
                            $result = $link->query("DELETE FROM Users WHERE FirstName='&#34;';");
                            if ($link->errno > 0) {
                                $output = "<div class='alert alert-danger'><strong>Errors while executing query: ".$link->error."</strong></div>";
                            } else {
                                $output = "<div class='alert alert-success'><strong>Query executed succesfully.</strong></div>";
                            }
                            $link->close();
                        }

                        echo $output;

                    ?>

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
