<?php
  
  require __DIR__.'/../boot/boot.php';

  use Hotel\User;
  // Check for existing logged in user
  if (!empty(User::getCurrentUserId())){
    // Return to home page
    header('Location: /hotel_app/public/index.php');die;
  }
  // else do not allow user to enter specific page

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title> Find Hotel </title>
</head>
 <body>
    <div class="preloader"></div> 
    <header>
        <div class="container-header">
            <div class="header-logo">
                <p >HOTELS</p>
            </div>
        <div class="menu-bar">
            <ul>
                <li>
                    <a href="../public/index.php" class="home-link">
                    <i class="fas fa-home"></i>
                        Home
                    </a>
                </li>
                <li> 
                    <a href="../public/login.php"class="login-link">
                        Login
                    </a>
                </li>
                <li>
                    <a href="../public/register.php" class="register-link">
                        Register
                    </a>
                </li>
            </ul>
        </div>
    </div>

    </header>

    <main class="main-content">
        <section class="img-container">
            <div class="login-form">
                <form class="myForm" name="myForm" method="GET" action="actions/login.php">
                    <div class="form-header">
                        <h2>Welcome back!</h2>
                    </div>
                        <?php if (!empty($_GET['error'])) { ?>
                            <div class="text-error"> Login Error </div>
                        <?php } ?>
                        <div class="login-field">
                            <i class="fas fa-user"></i>
                            <input id="email" name="email"  class="form-box" placeholder="Email" type="email" >
                            <div class="email-error text-error d-none">
                                Please enter an email!
                            </div>
                        </div>
                        <div class="login-field">
                            <i class="fas fa-lock"></i>
                            <input id = "password" name="password" class="form-box" placeholder="Password" type="password"> 
                            <i class="far fa-eye" id="togglePassword"style="margin-left: -30px; cursor: pointer;"></i>
                            <div class="password-error text-error d-none">
                                Please enter a password!
                            </div>  
                        </div>     
                        <button  type="submit" id="login-btn" class="submit-btn">Sign in</button>
                </form>
            </div>
        </section>
    </main>


    <footer>
        <p> &copy; 2021 Copyright Alexander Adam </p> 
    </footer>
    
    <link href="../public/assets/css/style-login.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="../public/assets/css/fontawesome.min.css">
    <script src="\hotel_app\public\assets\js\login.js"></script>

 </body>
</html>