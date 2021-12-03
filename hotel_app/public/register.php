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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
                    <a href="../public/login.php" class="login-link">
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
            <div class="register-form">
                <form class="myForm" name="myForm" method="POST" action="actions/register.php">
                    <div class="form-header">
                        <h2>Sign up</h2>
                    </div>
                    <?php if (!empty($_GET['error'])) { ?>
                        <div class="text-error"> Register Error </div>
                    <?php } ?>
                        <div class="login-field">
                            <i class="fas fa-user"></i>
                            <input id="name" name="name" class="form-box" placeholder="Full name" type="text" style="margin-left: 0.5%;">
                            <div class="name-error text-error d-none">
                                Please enter your first and last name!
                            </div>
                        </div>
                        <div class="login-field">
                            <i class="fas fa-envelope"></i>
                            <input id="email" name="email"  class="form-box" placeholder="Email" type="email">
                            <div class="email-error text-error d-none">
                                Please enter a valid email!
                            </div>
                        </div> 
                        <div class="login-field">
                            <input id="email_repeat" name="email_repeat" class="form-box" placeholder="Confirm email" type="email" style="margin-left: 5.7%;">
                            <div class="confirm-email-error text-error d-none">
                                Email not matching!
                            </div>
                        </div> 
                        <div class="login-field">
                            <i class="fas fa-lock"></i>
                            <input id = "password" name="password" class="form-box" placeholder="Password" type="password">  
                            <i class="far fa-eye" id="togglePassword"style="margin-left: -30px; cursor: pointer;"></i>           
                            <div class="password-validation text-error d-none">
                                <div class="policy-length">
                                - Containes minimun 8 Characters
                                </div>
                                <div class="policy-number">
                                - Contains a Number
                                </div>
                                <div class="policy-uppercase">
                                - Contains an uppercase character
                                </div>
                                <div class="policy-special">
                                - Contains Special Characters
                                </div>
                            </div>
                        </div>
                        <div class="action">
                            <button  type="submit" id="register-btn" class="submit-btn">Register</button>
                        </div>
                </form>
            </div>
        </section>
    </main>


    <footer>
        <p> &copy; 2021 Copyright Alexander Adam </p> 
    </footer>
    
    <link href="../public/assets/css/style-register.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="../public/assets/css/fontawesome.min.css">
    <script src="\hotel_app\public\assets\js\register.js"></script>

 </body>
</html>