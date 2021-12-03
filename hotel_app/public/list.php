<?php
    require __DIR__.'/../boot/boot.php';

    ini_set('display_errors', 0);
    error_reporting(E_ERROR | E_WARNING | E_PARSE); 
    

    use Hotel\Room;
    use Hotel\RoomType;
    use Hotel\User;

    

    // Initialize room service
    $room = new Room();
    $type = new RoomType();
    

    // Get all cities
    $cities = $room->getCities();
    // Get all room types
    $allTypes = $type->getAllTypes();
    // Get number of guests
    $number_of_guests = $room->getCountGuests();
    

    // Get page parameters
    $selectedCity = $_REQUEST['city'];
    $selectedTypeId =  $_REQUEST['room_type'];
    $checkInDate = $_REQUEST['check_in_date'];
    $checkOutDate = $_REQUEST['check_out_date'];
    $price1 = $_REQUEST['range1'];
    $price2 = $_REQUEST['range2'];
    $slider1 = $_REQUEST['slider-1'];
    $slider2 = $_REQUEST['slider-2'];
    $count_of_guests = $_REQUEST['count_of_guests'];
    // Search for room
    $allAvainableRooms =  $room->search(new DateTime($checkInDate), new DateTime($checkOutDate), $selectedCity, $price1=0, $price2=5000,  $count_of_guests, $selectedTypeId);
    // Check if a user is connected then remove login and register links
    $user = new User();
    $connectedUser = $user->getCurrentUserId();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title> Find Hotel </title> 
    

    <link rel="shortcut icon" href="#">

</head>
 <body>
    <div class="preloader"></div> 
    <header>
        <div class="container-header">
            <div class="header-logo">
                <p>HOTELS</p>
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
    <div class="fade-rule"></div>
    </header>

   <!-- Main section starts -->
    <main>
        <section class="container">
            <aside class="hotel-search box">
                <div class="form-title">
                    <h3>FIND THE PERFECT HOTEL </h3>
                </div>
                 <!-- The search form for hotels -->
                <form name="form-search" class="form-search" method="GET" action="<?=$_SERVER['PHP_SELF'];?>" autocomplete="off">

                    <select name="count_of_guests" id="guest" class="select-btn">
                        <option hidden disabled selected value="">Count of Guests</option>
                        <?php
                                foreach ($number_of_guests as $number_guest){   
                            ?>
                                <option <?php echo $count_of_guests == $number_guest ? 'selected="selected"' : '' ?> value="<?php echo  $number_guest ?>"> <?php echo $number_guest?> </option>
                            <?php
                                }
                            ?>
                    </select>

                    <select name="room_type" id="room" name="room_type" class="select-btn">
                    <option hidden disabled selected value="">Room Type</option>
                            <?php
                                foreach ($allTypes as $roomType){   
                            ?>
                                <option  <?php echo $selectedTypeId == $roomType['type_id'] ? 'selected="selected"' : '' ;?>value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title'];?></option>
                            <?php
                                }
                            ?>
                    </select>

                    <select name="city" id="city" class="select-btn">
                        <option value="" disabled selected hidden>City</option>
                                <?php
                                    foreach ($cities as $city){   
                                ?>
                                    <option <?php echo $selectedCity == $city ?'selected="selected"' : '';?> value="<?php echo $city; ?>"><?php echo $city; ?></option>
                                <?php
                                    }
                                ?>
                    </select>

                    <div class="box-price input-icon-right">
                        <i><input name="range1" id="range1" class="box-value" type="number" value="<?php echo  $price1  == null ? 0 : $price1?>" min="0" max="4900" step="1">€</i>
                        <i><input name="range2" id="range2" class="box-value" type="number" value="<?php echo  $price2  == null ? 5000 : $price2?>" min="0" max="5000" step="1">€</i>
                    </div>
                    <div class="price-slider">
                        <div class="slider-track"></div>
                        <input name="slider-1" id="slider-1" type="range" value="<?php echo  $slider1 == null ? 0 : $slider1 ?>" min="0" max="5000" >
                        <input name="slider-2"  id="slider-2" type="range" value="<?php echo  $slider2 == null ? 5000 : $slider2?>" min="0" max="5000" >
                    </div>
                    <div class="label-price">
                        <p>PRICE MIN.</p>
                        <p>PRICE MAX.</p>
                    </div>

                    <div class="dates-container">
                        <input name="check_in_date" class="check-in datepicker" type="text" placeholder="Check-in" id="checkin" value="<?php echo $checkInDate;?>">
                        <input name="check_out_date" class="check-out datepicker" type="text" placeholder="Check-out" id="checkout" value="<?php echo $checkOutDate;?>">
                    </div>
                    
                    <div class="action">
                        <button type="submit" class="submit-btn">FIND HOTEL</button>
                    </div>
                </form>
            </aside>
            <section class="hotel-list box">
                <header class="page-title">
                    <h3 style="margin-left: 10px;">Search Results</h3>
                </header>
            
                <!----------------------- The avainable hotels --------------------->
                <section id = "search-results-container">
                        <?php
                            foreach ($allAvainableRooms as $avainableRoom) {   
                        ?>
                            <article class="hotel">
                                <aside class="hotel-img">
                                    <img src="assets/images/<?php echo $avainableRoom['photo_url'] ?>" alt="room image" >
                                </aside>
                                <main class="hotel-info">
                                    <h3 style="margin-top: 0;"><?php echo $avainableRoom['name'] ?></h3>
                                    <h4 class="city-area-name"><?php echo $avainableRoom['area'] ?></h4>
                                        <p><?php echo $avainableRoom['description_short'] ?></p>
                                    <div class="room-btn"> 
                                        <a class="link-to-page" href="room.php?room_id=<?php echo $avainableRoom['room_id']?>&check_in_date=<?php echo $checkInDate?>&check_out_date=<?php echo $checkOutDate?>">Go to room page</a>
                                    </div>
                                </main>
                            </article> 
                            <div class="more-info">
                                <div class="per-night-info">
                                    <p>Per Night <?php echo $avainableRoom['price'] ?>&euro;</p>
                                </div>
                                <div class="group-more-info">
                                    <p >Count of guests: <?php echo $avainableRoom['count_of_guests'] ?></p>
                                    <p> | </p>
                                    <p>Type of Room: <?php echo $avainableRoom['room_type'] ?></p>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                            <?php
                                if (count($allAvainableRooms) == 0) {
                            ?>
                            <h2 class="no-rooms"> No search results!!! </h2> 
                            <hr>      
                            <?php
                                }
                            ?>
                </section>
            </section>
        </section>
      

    </main>

    <!-- Main section ends -->

    <footer>
        <p> &copy; 2021 Copyright Alexander Adam </p> 
        <!-- Scroll to top button  -->
        <button class="scroll-top">
            <i class="fas fa-arrow-up"></i>
        </button>
    </footer>
    <!-- Roboto fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">

    <!-- Date Range Picker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

    <!-- Sccripts and css -->  
    <script src="assets/js/list.js"></script>
    <link href="assets/css/style-list.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">

 </body>
</html>