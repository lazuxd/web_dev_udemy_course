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

        <title>Contact Form</title>

        <style>
            .contact-form {
                border: 1px solid #4009b7;
                border-radius: 15px;
                margin-top: 30px;
                padding-bottom: 15px;
            }
            .contact-form h1 {
                color: #4009b7;
            }
        </style>

    </head>
    <body>

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-offset-1 col-sm-10 contact-form">
                    <h1>Contact us</h1>
                    <?php
                        //data
                        $name = $_POST["name"];
                        $email = $_POST["email"];
                        $message = $_POST["message"];
                        //error messages
                        $nameMissing = "<p>Please enter your name!</p>";
                        $emailMissing = "<p>Please enter your email!</p>";
                        $messageMissing = "<p>Please enter your message!</p>";
                        $emailInvalid = "<p>Please enter a valid email!</p>";

                        $errors = "";

                        if ($_POST["submit"]) {
                            if (!$name) {
                                $errors .= $nameMissing;
                            } else {
                                $name = filter_var($name, FILTER_SANITIZE_STRING);
                            }
                            if (!$email) {
                                $errors .= $emailMissing;
                            } else {
                                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                    $errors .= $emailInvalid;
                                }
                            }
                            if (!$message) {
                                $errors .= $messageMissing;
                            } else {
                                $message = filter_var($message, FILTER_SANITIZE_STRING);
                            }

                            if ($errors != "") {
                                echo "<div class='alert alert-danger'><strong>" . $errors . "</strong></div>";
                            } else {
                                $to = "dorianlazar81@gmail.com";
                                $subject = "Contact";
                                $msg = "<p>Name: $name</p><p>Email: $email</p><p>Message:</p><p><strong>$message</strong></p>";
                                $header = "Content-type: text/html";
                                if (!mail($to, $subject, $msg, $header)) {
                                    echo "<div class='alert alert-danger'><strong>Unable to send email. Please try again later.</strong></div>";
                                } else {
                                    header("Location: 17b.contact_form.php");
                                }
                            }
                        }
                    ?>
                    <form method="post">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?php echo $_POST['name']; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo $_POST['email']; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea class="form-control" id="message" name="message" rows="5"><?php echo $_POST['message']; ?></textarea>
                        </div>
                        <input type="submit" class="btn btn-success btn-lg" id="submit" name="submit" value="Send message" />
                    </form>
                </div>
            </div>

        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script>

        </script>
    </body>
</html>
<?php ob_flush(); ?>
