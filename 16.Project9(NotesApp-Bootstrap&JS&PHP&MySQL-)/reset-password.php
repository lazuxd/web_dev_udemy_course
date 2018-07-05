<?php
    ob_start();
    session_start();
    require_once("include/data.php");
    require_once("include/UsersDb.php");
    $users = new UsersDb(HOSTNAME, USERNAME, PASSWORD, DATABASE);

    $users->remember();
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

            <?php
                $users->validateForgotPassword($_GET["key"], $_GET["email"]);
                if ($users->existErrors()) {
                    $result = "<div class='alert alert-danger'><strong>";
                    foreach ($users->errors as $error) {
                        $result .= "<p>$error</p>";
                    }
                    $result .= "</strong></div>";
                    echo $result;
                } else {
                    $launchModal = true;
                }

                $users->close();
            ?>

        </div>

        <form method="post" id="resetForm">
            <div class="modal" id="resetModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" data-dismiss="modal" style="font-size: 2em">&times;</button>
                            <h4>Reset password:</h4>
                        </div>
                        <div class="modal-body">
                            <div id="resetResult"></div>
                            <div class="form-group">
                                <label for="newPassword" class="sr-only">New password:</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" maxlength="30"/>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword" class="sr-only">Confirm password:</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" maxlength="30"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn greenBtn" id="resetSubmit" name="reset" value="Reset"/>
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
                <?php
                    if (empty($_SESSION['id'])) {
                        echo 'hide(["#notes", "#profile", "#loggedIn", "#logout"]);';
                    } else {
                        echo 'hide(["#home", "#login"]); updateUsername("'.$_SESSION['username'].'")';
                    }
                ?>
                $("#resetForm").submit(function(event) {
                    event.preventDefault();
                    var dataToPost = $(this).serializeArray();
                    dataToPost.push({name: 'key', value: '<?php echo $_GET['key']; ?>'}, {name: 'email', value: '<?php echo $_GET['email']; ?>'});
                    $.ajax({
                        url: "reset.php",
                        type: "POST",
                        data: dataToPost,
                        success: function(result) {
                            $("#resetResult").html(result);
                        },
                        error: function() {
                            $("#resetResult").html("<div class='alert alert-danger'>Failed to exexute Ajax call.</div>");
                        }
                    });
                });
                <?php if ($launchModal === true) echo "$('#resetModal').modal('show');"; ?>
            });
        </script>

    </body>

</html>
<?php
    ob_flush();
?>
