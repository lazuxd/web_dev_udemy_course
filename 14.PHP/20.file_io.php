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

        <title>File IO</title>

        <style>
            h1 {
                color: cyan;
                margin-top: 100px;
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

            <h1>File IO</h1>

            <p>

<?php

    define("endl", "<br/>");
    define("path", "bits.cpp");

    echo "File exists: ".file_exists(path).endl;
    echo "File size: ".filesize(path)." bytes".endl;
    $arr = file(path);
    echo "File contents:".endl;
    foreach($arr as $index => $line) {
        echo "Line #".($index+1).": ".$line.endl;
    }
    $newfile = fopen("numbers.dat", "r");
    if (!$newfile) {
        echo "File not opened".endl;
    } else {
        echo "File opened".endl;
    }
    $pi = fread($newfile, 4);
    $pi = unpack("f1", $pi)[1];
    // print_r($pi);
    echo $pi;

    fclose($newfile);

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
