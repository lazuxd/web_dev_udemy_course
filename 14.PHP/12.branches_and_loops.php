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

        <title>Branches and loops</title>

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

            <h1>Branches and loops:</h1>
            <p>
<?php
    define("endl", "<br/>");
    function endl() { echo endl; }

    $x = 3; $y = 5;
    if ($x<$y) {
        echo "$x&lt;$y".endl;
    } elseif ($x>$y) {
        echo "$x&gt;$y".endl;
    } else {
        echo "$x&equals;$y".endl;
    }

    $lang = "C++";
    switch ($lang) {
        case "Java":
            echo "Why Java programers wear glasses?".endl;
            break;
        case "C#":
            echo "Because they can't C#".endl;
            break;
        case "C++":
            echo "C++ is the best.".endl;
            break;
        default:
            echo "Choose a language".endl;
    }

    for ($i = 0; $i < 10; ++$i) {
        echo $i.endl;
    }

    $iarr = array("HTML", "CSS", "JS", "PHP");
    foreach ($iarr as $l) {
        echo $l.endl;
    }

    $aarr = array("Linus Torvalds" => "Linux Kernel", "Bill Gates" => "Windows", "Richard Stallman" => "Free As In Freedom");
    foreach ($aarr as $key => $value) {
        echo $key . " => " . $value . endl;
    }

    $i = 0;
    while ($i < 4) {
        echo $iarr[$i].endl;
        ++$i;
    }

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
