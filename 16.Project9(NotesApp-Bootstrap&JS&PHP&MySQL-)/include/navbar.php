<nav role="navigation" class="navbar navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Online Notes</a>
            <button class="navbar-toggle" data-toggle="collapse" data-target="#navList">
                <span class="sr-only">Navigation toggle button</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navList">
            <ul class="nav navbar-nav navbar-left">
                <li id="home"><a href="index.php">Home</a></li>
                <li id="notes"><a href="my-notes.php">My Notes</a></li>
                <li id="profile"><a href="profile.php">Profile</a></li>
                <li id="help"><a href="#">Help</a></li>
                <li id="contact"><a href="#">Contact us</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li id="loggedIn"><a>Logged in as <strong><span class="username">username</span></strong></a></li>
                <li id="logout"><a href="logout.php">Logout</a></li>
                <li id="login"><a href="#loginModal" data-toggle="modal">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<form method="post" id="loginForm">
    <div class="modal" id="loginModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" style="font-size: 2em">&times;</a>
                    <h4>Login:</h4>
                </div>
                <div class="modal-body">
                    <div id="loginResult"></div>
                    <div class="form-group">
                        <label for="loginEmail" class="sr-only">Email:</label>
                        <input type="email" class="form-control" id="loginEmail" name="email" placeholder="Email" maxlength="50"/>
                    </div>
                    <div class="form-group">
                        <label for="loginPassword" class="sr-only">Password:</label>
                        <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Password" maxlength="30"/>
                    </div>
                    <div class="form-inline">
                        <input type="checkbox" class="checkbox" id="loginRememberMe" name="rememberMe"/>
                        <label for="loginRememberMe" class="control-label" style="font-weight: normal">Remember me</label>
                        <a data-dismiss="modal" href="#forgotModal" data-toggle="modal" class="pull-right">Forgot Password?</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
                    <input type="submit" class="btn greenBtn" id="loginSubmit" name="login" value="Login"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form method="post" id="forgotForm">
    <div class="modal" id="forgotModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" style="font-size: 2em">&times;</a>
                    <h4>Forgot Password? Enter your email address: </h4>
                </div>
                <div class="modal-body">
                    <div id="forgotResult"></div>
                    <div class="form-group">
                        <label for="forgotEmail" class="sr-only">Email:</label>
                        <input type="email" class="form-control" id="forgotEmail" name="email" placeholder="Email" maxlength="50"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
                    <input type="submit" class="btn greenBtn" id="forgotSubmit" name="forgot" value="Submit"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
body {
    margin-top: 80px;
}

.modal-body {
    padding-bottom: 20px;
}

.navbar-custom {
  background-color: #6eb0d2;
  border-color: #55a2ca;
  background-image: -webkit-gradient(linear, left 0%, left 100%, from(#95c5de), to(#6eb0d2));
  background-image: -webkit-linear-gradient(top, #95c5de, 0%, #6eb0d2, 100%);
  background-image: -moz-linear-gradient(top, #95c5de 0%, #6eb0d2 100%);
  background-image: linear-gradient(to bottom, #95c5de 0%, #6eb0d2 100%);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff95c5de', endColorstr='#ff6eb0d2', GradientType=0);
}
.navbar-custom .navbar-brand {
  color: #ffffff;
}
.navbar-custom .navbar-brand:hover,
.navbar-custom .navbar-brand:focus {
  color: #e6e6e6;
  background-color: transparent;
}
.navbar-custom .navbar-text {
  color: #ffffff;
}
.navbar-custom .navbar-nav > li:last-child > a {
  border-right: 1px solid #55a2ca;
}
.navbar-custom .navbar-nav > li > a {
  color: #ffffff;
  border-left: 1px solid #55a2ca;
}
.navbar-custom .navbar-nav > li > a:hover,
.navbar-custom .navbar-nav > li > a:focus {
  color: #e0e0e0;
  background-color: transparent;
}
.navbar-custom .navbar-nav > .active > a,
.navbar-custom .navbar-nav > .active > a:hover,
.navbar-custom .navbar-nav > .active > a:focus {
  color: #e0e0e0;
  background-color: #55a2ca;
  background-image: -webkit-gradient(linear, left 0%, left 100%, from(#55a2ca), to(#7cb7d6));
  background-image: -webkit-linear-gradient(top, #55a2ca, 0%, #7cb7d6, 100%);
  background-image: -moz-linear-gradient(top, #55a2ca 0%, #7cb7d6 100%);
  background-image: linear-gradient(to bottom, #55a2ca 0%, #7cb7d6 100%);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff55a2ca', endColorstr='#ff7cb7d6', GradientType=0);
}
.navbar-custom .navbar-nav > .disabled > a,
.navbar-custom .navbar-nav > .disabled > a:hover,
.navbar-custom .navbar-nav > .disabled > a:focus {
  color: #cccccc;
  background-color: transparent;
}
.navbar-custom .navbar-toggle {
  border-color: #dddddd;
}
.navbar-custom .navbar-toggle:hover,
.navbar-custom .navbar-toggle:focus {
  background-color: #dddddd;
}
.navbar-custom .navbar-toggle .icon-bar {
  background-color: #cccccc;
}
.navbar-custom .navbar-collapse,
.navbar-custom .navbar-form {
  border-color: #53a1ca;
}
.navbar-custom .navbar-nav > .dropdown > a:hover .caret,
.navbar-custom .navbar-nav > .dropdown > a:focus .caret {
  border-top-color: #e0e0e0;
  border-bottom-color: #e0e0e0;
}
.navbar-custom .navbar-nav > .open > a,
.navbar-custom .navbar-nav > .open > a:hover,
.navbar-custom .navbar-nav > .open > a:focus {
  background-color: #55a2ca;
  color: #e0e0e0;
}
.navbar-custom .navbar-nav > .open > a .caret,
.navbar-custom .navbar-nav > .open > a:hover .caret,
.navbar-custom .navbar-nav > .open > a:focus .caret {
  border-top-color: #e0e0e0;
  border-bottom-color: #e0e0e0;
}
.navbar-custom .navbar-nav > .dropdown > a .caret {
  border-top-color: #ffffff;
  border-bottom-color: #ffffff;
}
@media (max-width: 767) {
  .navbar-custom .navbar-nav .open .dropdown-menu > li > a {
    color: #ffffff;
  }
  .navbar-custom .navbar-nav .open .dropdown-menu > li > a:hover,
  .navbar-custom .navbar-nav .open .dropdown-menu > li > a:focus {
    color: #e0e0e0;
    background-color: transparent;
  }
  .navbar-custom .navbar-nav .open .dropdown-menu > .active > a,
  .navbar-custom .navbar-nav .open .dropdown-menu > .active > a:hover,
  .navbar-custom .navbar-nav .open .dropdown-menu > .active > a:focus {
    color: #e0e0e0;
    background-color: #55a2ca;
  }
  .navbar-custom .navbar-nav .open .dropdown-menu > .disabled > a,
  .navbar-custom .navbar-nav .open .dropdown-menu > .disabled > a:hover,
  .navbar-custom .navbar-nav .open .dropdown-menu > .disabled > a:focus {
    color: #cccccc;
    background-color: transparent;
  }
}
.navbar-custom .navbar-link {
  color: #ffffff;
}
.navbar-custom .navbar-link:hover {
  color: #e0e0e0;
}
</style>
