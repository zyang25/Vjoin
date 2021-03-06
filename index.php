<?php
session_start();
require_once('main/auth_system.php');

$title = 'Stevens Activity Poster';
if(isset($_SESSION['user_id'])){
    header('Location: main');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Stevens Activity Poster</title>
        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    </head>
    <body>
        <!-- Top content -->
        <div class="top-content">
            
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>Stevens Activity Poster</strong> Login </h1>
                            <div class="description">
                                <p>
                                    This is a free platform only for stevens institute of technology students. Show yourself easily!
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                            <div class="form-top">
                                <div class="form-top-left">
                                    <h3>Login to our site</h3> 
                                    <h4>Welcome, You can use a test account.</h4>
                                    <h4>username: test</h4>
                                    <h4>password: 123456</h4>
                                </div>
                                <div class="form-top-right">
                                    <i class="fa fa-lock"></i>
                                </div>
                            </div>
                            <?php
                            
    
                            if(isset($_POST['email'])&&isset($_POST['password'])){
                            $user = new AuthSystem();
                            $status = $user -> login($_POST['email'],$_POST['password']);
                            
                            if( $status == 1 ||$status == 2 || $status ==3){
                            echo "Login successfully";
                            header("Location: main");
                            }else{
                            echo "<div class=\"alert alert-danger\" role=\"alert\">Email or password is not correct.</div>";
                            }
                            }
                            ?>
                            <div class="form-bottom">
                                <form role="form" action="." method="post" class="login-form" id="login_form">
                                    <div class="form-group">
                                        <label class="sr-only" for="form-username">Email</label>
                                        <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="2" required>
                                        <span id="email_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3" required>
                                        <span id="password_error"></span>
                                    </div>
                                    <button type="submit" id="submit" class="btn">Sign in!</button>
                                </form>
                                <div class="row">
                                    
                                    <div  class="col-sm-12">
                                        <div class="col-sm-5 col-sm-offset-2"><a href="main/forgot_password.php">forget password</a></div>
                                        <div class="col-sm-4"><a href="main/register.php">signup</a></div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>
        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
        <script src="assets/js/placeholder.js"></script>
        <![endif]-->
        

        <script>
        function check_email(){
            var pattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
            var stevens_email = /^\w+@(stevens.edu)$/;
            var email = document.getElementById("email").value;
            var r = stevens_email.test(email);
            if (r == false)
                document.getElementById("email_error").innerHTML = "Please use Stevens edu email.";
            console.log(r);
            return r;
        };
        function check_password(){

            var password1 = document.getElementById("password").value;
            console.log("Checking.");
            if(password1.length<6){
                document.getElementById("password_error").innerHTML = "Password error";
                return false;
            }
            return true;
        };
        $('#login_form').bind("submit",function(e){
            
            if(check_password()){
                $(this).unbind("submit");
                $('#login_form').submit();
            }else{
                 e.preventDefault();
            }
            
        });
        </script>
        
    </body>
</html>
