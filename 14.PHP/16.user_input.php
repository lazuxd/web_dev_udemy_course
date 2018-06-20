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

        <title>User Input</title>

        <style>
            h1 {
                color: cyan;
            }

            p {
                font-family: monospace;
                background: lime;
                color: black;
                letter-spacing: 2px;
                min-height: 200px;
                padding: 10px;
            }
        </style>

    </head>
    <body>

        <div class="container-fluid">

            <h1>User Input:</h1>

            <form method="get">
                <label for="username">Username: </label>
                <input type="text" name="username" id="username"/>
                <input type="submit" name="submit" value="Submit"/>
            </form>

            <form method="post">
                <label for="password">Password: </label>
                <input type="password" name="password" id="password"/>
                <input type="submit" name="submit" value="Submit"/>
            </form>

            <p>
<?php
    define("endl", "<br/>");
    function endl() { echo endl; }

    echo "Get:".endl;
    //echo $_GET['username'].endl;
    echo filter_var($_GET['username'], FILTER_SANITIZE_STRING);

    echo endl."Post:".endl;
    print_r($_POST); endl();
    echo $_POST['password'] == null ? "No password" : "Password exist";

?>
            </p>

        </div>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script>

        </script>
    </body>
</html>
