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

        <title>My Notes</title>

        <link rel="stylesheet" href="style.css"/>

        <style>
            #notesBtns {
                margin-top: 50px;
                height: 70px;
            }
            #noteTextArea {
                resize: none;
                box-sizing: border-box;
                width: 100%;
                border: 3px solid #ea0cf2;
                border-left: 20px solid #ea0cf2;
                padding: 20px;
                font-size: 1.8em;
                color: #ea0cf2;
            }
            .noteRow {
                height: 80px;
                margin-bottom: 15px;
            }
            .noteDelete, .noteContainer {
                height: 80px;
            }
            .noteContent {
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                cursor: pointer;
                user-select: none;
                box-sizing: border-box;
                border: 1px solid #000000;
                border-radius: 15px;
                background-color: #e8ecf2;
                padding: 5px 15px 5px 15px;
                margin-top: 40px;
                -webkit-transform: translateY(-50%);
                -moz-transform: translateY(-50%);
                -o-transform: translateY(-50%);
                -ms-transform: translateY(-50%);
                transform: translateY(-50%);
            }
            .noteText {
                font-size: 1.5em;
            }
            .noteText, .noteTime {
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
                word-wrap: normal;
                word-break: keep-all;
            }
            .deleteBtn {
                width: 100%;
                margin-top: 40px;
                -webkit-transform: translateY(-50%);
                -moz-transform: translateY(-50%);
                -o-transform: translateY(-50%);
                -ms-transform: translateY(-50%);
                transform: translateY(-50%);
            }
        </style>

    </head>

    <body>

        <?php require("include/navbar.php"); ?>

        <div class="container">

            <div id="notesBtns">
                <button id="addNote" class="btn btn-info btn-lg pull-left">Add Note</button>
                <button id="allNotes" class="btn btn-info btn-lg pull-left">All Notes</button>
                <button id="edit" class="btn btn-info btn-lg pull-right">Edit</button>
                <button id="done" class="btn btn-success btn-lg pull-right">Done</button>
            </div>
            <div id="notesDiv"></div>
            <textarea rows="12" name="noteTextArea" id="noteTextArea"></textarea>

        </div>

        <?php require("include/footer.php"); ?>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <script src="code.js"></script>

        <script>
        function loadNotes() {
            $.ajax({
                url: "load-notes.php",
                type: "POST",
                timeout: 3000,
                data: {userId: <?php echo $_SESSION['id']; ?>,
                       timeOffsetMinutes: (new Date()).getTimezoneOffset()
                },
                success: function(result) {
                    $("#notesDiv").html(result);
                    hideDeleteBtns();
                    addClickEventOnNotes();
                    addClickEventOnDeleteBtns();
                },
                error: function() {
                    $("#notesDiv").html("<div class='alert alert-danger'>Failed to exexute Ajax call.</div>");
                }
            });
        }
        function addClickEventOnDeleteBtns() {
            $(".deleteBtn").click(function() {
                var e = $(this).parent().parent();
                var id = e.attr('id');
                e.remove();
                $.ajax({
                    url: "delete-note.php",
                    type: "POST",
                    timeout: 3000,
                    data: {noteId: id},
                    success: function(result) {
                        if (result !== "success") {
                            $("#notesDiv").prepend(result);
                        }
                    },
                    error: function() {
                        $("#notesDiv").prepend("<div class='alert alert-danger'>Failed to exexute Ajax call.</div>");
                    }
                });
            });
        }
        function createNote() {
            $.ajax({
                url: "create-note.php",
                type: "POST",
                timeout: 3000,
                data: {userId: <?php echo $_SESSION['id']; ?>},
                success: function(result) {
                    if (result.match(/^([0-9])+$/)) {
                        hide(["#addNote", "#edit", "#notesDiv", "#done"]);
                        $("#noteTextArea").attr('name', result);
                        $("#noteTextArea").val("");
                        show(["#allNotes", "#noteTextArea"]);
                    } else {
                        $("#notesDiv").prepend(result);
                    }
                },
                error: function() {
                    $("#notesDiv").prepend("<div class='alert alert-danger'>Failed to exexute Ajax call.</div>");
                }
            });
        }
        function updateNote() {
            $.ajax({
                url: "update-note.php",
                type: "POST",
                timeout: 3000,
                data: {noteId: parseInt($("#noteTextArea").attr('name')),
                       newNote: $("#noteTextArea").val()
                },
                success: function(result) {
                    if (result !== "success") {
                        $("#noteTextArea").before(result);
                    }
                },
                error: function() {
                    $("#noteTextArea").before("<div class='alert alert-danger'>Failed to exexute Ajax call.</div>");
                }
            });
        }
        function hideDeleteBtns() {
            $(".noteDelete").removeClass("col-xs-5 col-sm-3");
            hide([".noteDelete"]);
            $(".noteContainer").removeClass("col-xs-7 col-sm-9");
            $(".noteContainer").addClass("col-xs-12");
        }
        function showDeleteBtns() {
            $(".noteDelete").addClass("col-xs-5 col-sm-3");
            show([".noteDelete"]);
            $(".noteContainer").removeClass("col-xs-12");
            $(".noteContainer").addClass("col-xs-7 col-sm-9");
        }
        function addClickEventOnNotes() {
            $(".noteContent").on("click", function() {
                hide(["#addNote", "#edit", "#notesDiv"]);
                $("#noteTextArea").attr('name', $(this).parent().parent().attr('id'));
                $("#noteTextArea").val($(this).find(".noteText").text());
                show(["#allNotes", "#noteTextArea"]);
            });
        }
        function removeClickEventOnNotes() {
            $(".noteContent").off("click");
        }

        $(function() {
            hide(["#noteTextArea", "#home", "#login", "#allNotes", "#done"]);
            $("#notes").addClass("active");
            updateUsername('<?php echo $_SESSION['username']; ?>');
            loadNotes();
            $("#addNote").click(createNote);
            $("#noteTextArea").keyup(updateNote);
            $("#allNotes").click(function() {
                $("#notesDiv").html("");
                hide(["#allNotes", "#noteTextArea", "#done"]);
                show(["#addNote", "#edit", "#notesDiv"]);
                loadNotes();
            });
            $("#edit").click(function() {
                hide(["#edit"]);
                show(["#done"]);
                showDeleteBtns();
                removeClickEventOnNotes();
            });
            $("#done").click(function() {
                show(["#edit"]);
                hide(["#done"]);
                hideDeleteBtns();
                addClickEventOnNotes();
                if ($("#notesDiv").children().length == 0) {
                    $("#notesDiv").prepend("<div class='alert alert-warning'><strong>There are no notes yet.</strong></div>");
                }
            });
        });
        </script>

    </body>

</html>
<?php
    ob_flush();
?>
