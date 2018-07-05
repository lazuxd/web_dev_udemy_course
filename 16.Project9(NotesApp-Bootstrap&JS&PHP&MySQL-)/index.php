<?php
    ob_start();
    session_start();
    require_once("include/data.php");
    require_once("include/UsersDb.php");
    $users = new UsersDb(HOSTNAME, USERNAME, PASSWORD, DATABASE);
    $users->remember();
    //user is logged in
    if (isset($_SESSION['id'])) {
        header("Location: my-notes.php");
    }
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
        <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
        <!-- Optional theme -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->

        <title>Online Notes</title>

        <link rel="stylesheet" href="style.css"/>

        <style>

        </style>

    </head>

    <body>

        <?php require("include/navbar.php"); ?>

        <div class="container">

            <div class="jumbotron">
                <h1>Online Notes App</h1>
                <p>Your Notes with you wherever you go.</p>
                <p>Easy to use, protects all your notes!</p>
                <button type="button" class="btn greenBtn btn-lg" data-target="#signupModal" data-toggle="modal">Sign up - It's free</button>
            </div>

        </div>

        <form method="post" id="signupForm">
            <div class="modal" id="signupModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <a class="close" data-dismiss="modal" style="font-size: 2em">&times;</a>
                            <h4>Sign up today and Start using our Online Notes App! </h4>
                        </div>
                        <div class="modal-body">
                            <div id="signupResult"></div>
                            <div class="form-group">
                                <label for="signupUsername" class="sr-only">Username:</label>
                                <input type="text" class="form-control" id="signupUsername" name="username" placeholder="Username" maxlength="30"/>
                            </div>
                            <div class="form-group">
                                <label for="signupEmail" class="sr-only">Email:</label>
                                <input type="email" class="form-control" id="signupEmail" name="email" placeholder="Email Address" maxlength="50"/>
                            </div>
                            <div class="form-group">
                                <label for="signupPassword" class="sr-only">Choose a password:</label>
                                <input type="password" class="form-control" id="signupPassword" name="password" placeholder="Choose a password" maxlength="30"/>
                            </div>
                            <div class="form-group">
                                <label for="signupPasswordConfirm" class="sr-only">Confirm password:</label>
                                <input type="password" class="form-control" id="signupPasswordConfirm" name="passwordConfirm" placeholder="Confirm password" maxlength="30"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn greenBtn" id="signupSubmit" name="signup" value="Sign up"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <?php require("include/footer.php"); ?>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <script src="code.js"></script>

        <script>
            $(function() {
                hide(["#notes", "#profile", "#loggedIn", "#logout"]);
                $("#home").addClass("active");
            });
        </script>

    </body>

</html>
<?php
    ob_flush();
?>
