function hide(arr) {
    var i;
    for (i = 0; i < arr.length; i++) {
        $(arr[i]).hide();
    }
}

function show(arr) {
    var i;
    for (i = 0; i < arr.length; i++) {
        $(arr[i]).show();
    }
}

function updateUsername(username) {
    $(".username").html(username);
}

function updateEmail(email) {
    $(".email").html(email);
}

$(function() {
    $("#signupForm").submit(function(event) {
        event.preventDefault();
        var dataToPost = $(this).serializeArray();
        $.ajax({
            url: "signup.php",
            type: "POST",
            data: dataToPost,
            success: function(result) {
                $("#signupResult").html(result);
            },
            error: function() {
                $("#signupResult").html("<div class='alert alert-danger'>Failed to exexute Ajax call.</div>");
            }
        });
    });
    $("#loginForm").submit(function(event) {
        event.preventDefault();
        var dataToPost = $(this).serializeArray();
        $.ajax({
            url: "login.php",
            type: "POST",
            data: dataToPost,
            success: function(result) {
                if (result == "success") {
                    window.location = "my-notes.php";
                } else {
                    $("#loginResult").html(result);
                }
            },
            error: function() {
                $("#loginResult").html("<div class='alert alert-danger'>Failed to exexute Ajax call.</div>");
            }
        });
    });
    $("#forgotForm").submit(function(event) {
        event.preventDefault();
        var dataToPost = $(this).serializeArray();
        $.ajax({
            url: "forgot-password.php",
            type: "POST",
            data: dataToPost,
            success: function(result) {
                $("#forgotResult").html(result);
            },
            error: function() {
                $("#forgotResult").html("<div class='alert alert-danger'>Failed to exexute Ajax call.</div>");
            }
        });
    });
    $("#loginModal").on("shown.bs.modal", function() {
        $("#loginEmail").trigger("focus");
        $("#loginResult").html("");
    });
    $("#forgotModal").on("shown.bs.modal", function() {
        $("#forgotEmail").trigger("focus");
        $("#forgotResult").html("");
    });
    $("#signupModal").on("shown.bs.modal", function() {
        $("#signupUsername").trigger("focus");
        $("#signupResult").html("");
    });
    $("#usernameModal").on("shown.bs.modal", function() {
        $("#newUsername").trigger("focus");
        $("#usernameResult").html("");
    });
    $("#emailModal").on("shown.bs.modal", function() {
        $("#newEmail").trigger("focus");
        $("#emailResult").html("");
    });
    $("#passwordModal").on("shown.bs.modal", function() {
        $("#currentPassword").trigger("focus");
        $("#passwordResult").html("");
    });
    $("#resetModal").on("shown.bs.modal", function() {
        $("#newPassword").trigger("focus");
        $("#resetResult").html("");
    });
});
