<?php
    ob_start();
    session_start();
    require_once("include/data.php");
    require_once("include/UsersDb.php");
    $users = new UsersDb(HOSTNAME, USERNAME, PASSWORD, DATABASE);
    $users->remember();
    //user is logged in
    if (!isset($_SESSION['id'])) {
        header("Location: index.php");
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

        <title>Profile</title>

        <link rel="stylesheet" href="style.css"/>

        <style>
            .profileContainer {
                text-align: center;
            }
            .heading {
                margin-top: 70px;
                margin-bottom: 50px;
            }
            .userData {
                background: #e3e8ef7f;
            }
            .userData tr {
                cursor: pointer;
            }
        </style>

    </head>

    <body>

        <?php require("include/navbar.php"); ?>

        <div class="container profileContainer">

            <h1 class="heading">General Account Settings:</h1>
            <div class="table-responsive">
                <table class="userData table table-hover table-condensed table-bordered">
                    <tr data-target="#usernameModal" data-toggle="modal"><th>Username</th><td class="username"></td></tr>
                    <tr data-target="#emailModal" data-toggle="modal"><th>Email</th><td class="email"></td></tr>
                    <tr data-target="#passwordModal" data-toggle="modal"><th>Password</th><td>hidden</td></tr>
                </table>
            </div>

        </div>

        <form method="post" id="usernameForm">
            <div class="modal" id="usernameModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <a class="close" data-dismiss="modal" style="font-size: 2em">&times;</a>
                            <h4>Change your username:</h4>
                        </div>
                        <div class="modal-body">
                            <div id="usernameResult"></div>
                            <div class="form-group">
                                <label for="newUsername" class="sr-only">New Username:</label>
                                <input type="text" class="form-control" id="newUsername" name="newUsername" placeholder="New Username" maxlength="30"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn greenBtn" id="usernameSubmit" name="usernameSubmit" value="Submit"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form method="post" id="emailForm">
            <div class="modal" id="emailModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <a class="close" data-dismiss="modal" style="font-size: 2em">&times;</a>
                            <h4>Change your email address:</h4>
                        </div>
                        <div class="modal-body">
                            <div id="emailResult"></div>
                            <div class="form-group">
                                <label for="newEmail" class="sr-only">New Email:</label>
                                <input type="email" class="form-control" id="newEmail" name="newEmail" placeholder="New Email" maxlength="50"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn greenBtn" id="emailSubmit" name="emailSubmit" value="Submit"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form method="post" id="passwordForm">
            <div class="modal" id="passwordModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <a class="close" data-dismiss="modal" style="font-size: 2em">&times;</a>
                            <h4>Change your password:</h4>
                        </div>
                        <div class="modal-body">
                            <div id="passwordResult"></div>
                            <div class="form-group">
                                <label for="currentPassword" class="sr-only">Current Password:</label>
                                <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Current Password" maxlength="30"/>
                            </div>
                            <div class="form-group">
                                <label for="newPassword1" class="sr-only">New Password:</label>
                                <input type="password" class="form-control" id="newPassword1" name="newPassword1" placeholder="New Password" maxlength="30"/>
                            </div>
                            <div class="form-group">
                                <label for="newPassword2" class="sr-only">Confirm New Password:</label>
                                <input type="password" class="form-control" id="newPassword2" name="newPassword2" placeholder="Confirm New Password" maxlength="30"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn greenBtn" id="passwordSubmit" name="passwordSubmit" value="Submit"/>
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
            hide(["#home", "#login"]);
            $("#profile").addClass("active");
            updateUsername('<?php echo $_SESSION['username']; ?>');
            updateEmail('<?php echo $_SESSION['email']; ?>');
            $("#usernameForm").submit(function(event) {
                event.preventDefault();
                var dataToPost = $(this).serializeArray();
                $.ajax({
                    url: "change-username.php",
                    type: "POST",
                    timeout: 3000,
                    data: dataToPost,
                    success: function(result) {
                        var res = JSON.parse(result);
                        if (res.success) {
                            updateUsername(res.username);
                        }
                        $("#usernameResult").html(res.html);
                    },
                    error: function() {
                        $("#usernameResult").html("<div class='alert alert-danger'>Failed to exexute Ajax call.</div>");
                    }
                });
            });
            $("#emailForm").submit(function(event) {
                event.preventDefault();
                var dataToPost = $(this).serializeArray();
                $.ajax({
                    url: "request-change-email.php",
                    type: "POST",
                    timeout: 3000,
                    data: dataToPost,
                    success: function(result) {
                        $("#emailResult").html(result);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $("#emailResult").html("<div class='alert alert-danger'>Failed to exexute Ajax call: "+textStatus+", "+errorThrown+"</div>");
                    }
                });
            });
            $("#passwordForm").submit(function(event) {
                event.preventDefault();
                var dataToPost = $(this).serializeArray();
                $.ajax({
                    url: "change-password.php",
                    type: "POST",
                    timeout: 3000,
                    data: dataToPost,
                    success: function(result) {
                        $("#passwordResult").html(result);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $("#passwordResult").html("<div class='alert alert-danger'>Failed to exexute Ajax call: "+textStatus+", "+errorThrown+"</div>");
                    }
                });
            });
        });
        </script>

    </body>

</html>
<?php
    ob_flush();
?>
