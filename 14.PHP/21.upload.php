<?php ob_start(); ?>
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

        <title>Upload</title>

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
                    <h1>Upload</h1>

                    <?php
                        if ($_POST["submit"]) {
                            $name = basename($_FILES["file"]["name"]);
                            $targetName = "uploads/".$name;
                            $type = $_FILES["file"]["type"];
                            $tmpName = $_FILES["file"]["tmp_name"];
                            $error = $_FILES["file"]["error"];
                            $size = $_FILES["file"]["size"];

                            //errors
                            $noFile = "<p>Please choose a file!</p>";
                            $alreadyExists = "<p>The file already exists!</p>";
                            $tooBig = "<p>The file must be smaller than 50 MB!</p>";
                            $wrongType = "<p>Only pdf and text files are accepted!</p>";
                            $unexpected = "<p>An unexpected error occur!</p>";

                            $errors = "";
                            $result = "";
                            $allowedTypes = array("pdf" => "application/pdf", "text" => "text/plain");

                            if ($error == 4) {
                                $errors .= $noFile;
                            } else {
                                if (file_exists($targetName)) {
                                    $errors .= $alreadyExists;
                                }
                                if ($size > 50*1024*1024) {
                                    $errors .= $tooBig;
                                }
                                if (!in_array($type, $allowedTypes)) {
                                    $errors .= $wrongType;
                                }
                                if ($error > 0) {
                                    $errors .= $unexpected;
                                }
                            }

                            if ($errors != "") {
                                $result = "<div class='alert alert-danger'><strong>".$errors."</strong></div>";
                            } else {
                                if (!move_uploaded_file($tmpName, $targetName)) {
                                    $result = "<div class='alert alert-danger'><strong>Cannot upload the file. Please try again later.</strong></div>";
                                } else {
                                    $result = "<div class='alert alert-success'><strong>File uploaded succesfully. Thank you for using our services.</strong></div>";
                                }
                            }

                            echo $result;

                        }
                    ?>

                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="file">Upload a file:</label>
                            <input type="file" class="form-control" id="file" placeholder="File" name="file" />
                        </div>
                        <input type="submit" class="btn btn-success btn-lg" id="submit" name="submit" value="Upload" />
                    </form>

                </div>
            </div>

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
