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

        <title>Classes and objects</title>

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

            <h1>Classes and objects:</h1>
            <p>
<?php
    define("endl", "<br/>");
    function endl() { echo endl; }

    class Person {
        //data
        private $CNP;
        private $name;

        //methods
        public function __construct($CNP, $name) {
            $this->CNP = $CNP;
            $this->name = $name;
        }
        public function __toString() {
            return "Person $this->name has CNP $this->CNP.";
        }
        public function getName() {
            return $this->name;
        }
        public function getCNP() {
            return $this->CNP;
        }
    }

    class Student extends Person {
        //data
        private $media;
        //methods
        public function __construct($CNP, $name, $media) {
            parent::__construct($CNP, $name);
            $this->media = $media;
        }
        public function __toString() {
            return "Studentul ".$this->getName()." are CNP-ul ".$this->getCNP()." și media $this->media.";
        }
        public function getMedia() {
            return $this->media;
        }
    }

    $p1 = new Person(123456789, "Elon Musk");
    echo $p1.endl;
    $s1 = new Student(123456789, "Chuck Norris", 9.9);
    echo $s1.endl;
    var_dump($p1); endl();
    var_dump($s1); endl();
    $p2 = new Person(123456789, "Bill Gates");
    var_dump($p2); endl();

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
