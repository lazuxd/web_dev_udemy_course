<?php
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

        <title>Create table</title>

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
                    <h1>Connect to database</h1>

                    <?php

                        $link = @new mysqli(HOSTNAME, USERNAME, PASSWORD, "Users");
                        if ($link->connect_errno > 0) {
                            die("Unable to connect to database: ".$link->connect_error);
                        }

                        echo "<p>Succesfully conected to database.</p>";

                    ?>

                    <h1>Create table</h1>

                    <?php

                        $sql = "CREATE TABLE Users (
                            ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            FirstName VARCHAR(20) NOT NULL,
                            LastName VARCHAR(20) NOT NULL,
                            Email VARCHAR(30) NOT NULL,
                            Password VARCHAR(30) NOT NULL
                        );";

                        if ($link->query($sql)) {
                            echo "<p>Table 'Users' was succesfully created.</p>";
                        } else {
                            echo "<p>Table 'Users' cannot be created.</p>";
                        }

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
