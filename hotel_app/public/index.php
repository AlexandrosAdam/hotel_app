<?php
    require __DIR__.'/../boot/boot.php';

    use Hotel\Room;
    use Hotel\RoomType;
    use Hotel\User;

    // Get cities 
    $room = new Room();
    $cities = $room->getCities();
    

    // Get all room types
    $type = new RoomType();
    $allTypes = $type->getAllTypes();
   
    // Check if a user is connected then remove login and register links
    $user = new User();
    $connectedUser = $user->getCurrentUserId();
    
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
                    <?php
                        if (empty($connectedUser)) {
                    ?>
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
                    <?php
                        } else {
                    ?>

                    <li> 
                    <a href="../public/profile.php" class="profile-link">
                    <i class="fas fa-user-circle"></i>
                        Profile
                    </a>
                    </li>
                    <li> 
                    <a href="../public/logout.php" class="logout-link">
                    <i class="fas fa-door-open"></i>
                        Logout
                    </a>
                    </li>
                    <?php
                        }
                    ?>
                </ul>
            </div>
        </div>

    </header>

    <main>
        <section class="img-container">
            <div class="form-search">
                <form method="GET" action="list.php" class="form-hotel" autocomplete="off">
                   
                    <div class="form-dropdown">
                        <select name="city" id="city" class="city-drop" >
                            <option value="" disabled selected hidden>City</option>
                            <?php
                                foreach ($cities as $city){   
                            ?>
                                <option  value="<?php echo $city; ?>"><?php echo $city; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                        <select name="room_type" id="room" class="room-drop">
                            <option hidden disabled selected value="">Room Type</option>
                            <?php
                                foreach ($allTypes as $roomType){   
                            ?>
                                <option  value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="dates-container">
                        <input class="check-in datepicker" type="text" name="check_in_date" placeholder="Check-in" id="checkin">
                        <input class="check-out datepicker" type="text" name="check_out_date" placeholder="Check-in" id="checkout">
                    </div>
                    <div class="action">
                        <button type="submit" class="submit-btn" > Search </button> 
                    </div>
                    <div class="text-danger d-none">
                        City, check-in and check-out fields must be selected!
                    </div>

                </form>
            </div>
        </section>
    </main>

    <!-- Main section ends -->

    <footer>
        <p> &copy; 2021 Copyright Alexander Adam </p> 
    </footer>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    
    <link href="..\public\assets\css\style-index.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="../public/assets/css/fontawesome.min.css">

    <script src="..\public\assets\js\index.js"></script>

 </body>
</html>