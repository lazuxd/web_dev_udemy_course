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

        <title>Array functions</title>

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

            <h1>Array functions:</h1>

            <p>
<?php
    define("endl", "<br/>");
    function endl() { echo endl; }

    $a1 = array("HTML", "CSS", "JS", "PHP");
    $a2 = array("C++", "Java", "C#", "Python", "PHP", "JS");
    $a3 = array("Linus Torvalds" => "Linux Kernel", "Bill Gates" => "Windows", "Richard Stallman" => "Free As In Freedom");
    $a4 = array("Tim Berners-Lee" => "Web", "Stephen Prata" => "C++ Primer Plus", "Robert Sedgewick" => "Algorithms in C");

    echo '$a1 = '; print_r($a1); endl();
    echo '$a2 = '; print_r($a2); endl();
    echo '$a3 = '; print_r($a3); endl();
    echo '$a4 = '; print_r($a4); endl();

    $a5 = array_merge($a1, $a2);
    echo "Merge \$a1 & \$a2: "; print_r($a5); endl();
    echo "Nr of elements: " . count($a5) . endl;
    $cnt = array_count_values($a5);
    echo "Counted values: "; print_r($cnt); endl();
    echo 'Nr of PHP: ' . $cnt["PHP"] . endl;
    echo 'Is Web in $a4? : ' . (in_array("Web", $a4) ? "true" : "false") . endl;
    array_push($a2, "Ruby");
    echo '$a2 after pushed: '; print_r($a2); endl();
    array_splice($a2, 4, 2, array("Kotlin", "Golang"));
    echo "\$a2 after splice: "; print_r($a2); endl();
    sort($a1);
    echo "sorted \$a1: "; print_r($a1); endl();
    rsort($a1);
    echo "reversed \$a1: "; print_r($a1); endl();
    asort($a3);
    echo "sorted \$a3 by value: "; print_r($a3); endl();
    arsort($a3);
    echo "revrsed \$a3 by value: "; print_r($a3); endl();
    ksort($a3);
    echo "sorted \$a3 by key: "; print_r($a3); endl();
    krsort($a3);
    echo "reversed \$a3 by key: "; print_r($a3); endl();

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
