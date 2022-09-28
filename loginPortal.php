<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Login Portal</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function login() {
                $.ajax({
                    url: "login/login.php",
                    type: "POST",
                    data: $("#loginForm").serialize()
                }).done(function(data) {
                    alert(data);
                    window.location.href="dbms.php";
                }).fail(function(jqXHR) {
                    alert("Error: " + jqXHR.responseText);
                    $("#loginForm").trigger("reset");
                });
            }
        </script>
        <style>
            /**/
        </style>
    </head>
    <body>
        <div class="container vh-100 d-flex">
            <div class="jumbotron justify-content-center align-self-center w-100">
                <h1 class="text-center">Login Portal</h1>
                <form class="was-validated" id="loginForm" action="javascript:void(0)" method="post" name="loginForm" onsubmit="login()">
                    <div class="form-group">
                        <label for="email">Employee Email:</label>
                        <input type="email" class="form-control" placeholder="Enter email" id="email" name="email" required />
                        <div class="valid-feedback">Email looks good.</div>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control" type="password" placeholder="Enter password" id="password" name="password" required />
                        <div class="valid-feedback">Password looks good.</div>
                        <div class="invalid-feedback">Please enter your password.</div>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" id="loginButton" value="Login" />
                    </div>
                </form>
            </div>
        </div>
        <script> 
            $(document).ready(function(){
            });
        </script>
    </body>
</html>
