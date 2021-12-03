<?php 

    require __DIR__.'/../boot/boot.php';

    use Hotel\Favorite;
    use Hotel\Review;
    use Hotel\Booking;
    use Hotel\User;

    // Check for logged in user
    $userId = User::getCurrentUserId();
    if (empty($userId)){
        header('Location: index.php');

        return;
    }

    // Get all favorites
    $favorite = new Favorite();
    $userFavorites = $favorite->getListByUser($userId);
    
    // Get all reviews
    $review = new Review();
    $userReviews = $review->getListByUser($userId);
    
    // Get all user bookings
    $booking = new Booking();
    $userBookings = $booking->getListByUser($userId);
    


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
                    <h3> <strong> Favorites </strong> </h3>
                </div>
                <?php
                    if (count($userFavorites) > 0) {
                ?>
                <div class="favorites">
                    <ol>
                        <?php 
                            foreach ($userFavorites as $favorite) {
                        ?>
                        <h3>
                            <li>
                                <a href="room.php?room_id=<?php echo $favorite['room_id'] ?>"><?php echo $favorite['name'] ?></a>
                            </li>
                        </h3>
                        <?php 
                            }
                        ?>
                    </ol>
                </div>
                <?php
                    } else {
                ?>
                    <h4 class="alert-profile"> You don't have any favorite Hotel!</h4>
                <?php
                    } 
                ?>
                <div class="form-title">
                    <h3><strong> Reviews</strong></h3>
                </div>
                <?php
                    if (count($userReviews) > 0) {
                ?>
                <div class="reviews">
                    <ol>
                        <?php 
                            foreach ($userReviews as $review) {
                        ?>
                        <h3>
                            <li>
                                <a href="room.php?room_id=<?php echo $review['room_id'] ?>"><?php echo $review['name'] ?></a>
                                <br>
                                <?php 
                                    for ($i = 1; $i <=5; $i++) {
                                        if ($review['rate'] >= $i) {
                                            ?>
                                            <span class="fa fa-star checked"></span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class="fa fa-star"></span>
                                            <?php
                                        }
                                    }
                                 ?>
                            </li>
                        </h3>
                        <?php 
                            }
                        ?>
                    </ol>
                </div> 
                <?php
                    } else {
                ?>
                    <h4 class="alert-profile"> You don't have any review yet!</h4>
                <?php
                    } 
                ?>  
            </aside>
            <section class="hotel-list box">
                <header class="page-title">
                    <h3 style="margin-left: 10px;">My bookings</h3>
                </header>
                    <!-------------------- Bookings Review -------------------->
                    <?php
                        if (count($userBookings) > 0) {
                    ?>
                    <?php 
                        foreach ($userBookings as $booking) {
                    ?>
                    <article class="hotel">
                        
                        <aside class="hotel-img">
                            <img src="assets/images/<?php echo $booking['photo_url'] ?>"alt="room image">
                        </aside>
                        <main class="hotel-info">
                            <h3 style="margin-top: 0;"><?php echo $booking['name'] ?></h3>
                            <br>
                            <h4 class="city-area-name"><?php echo sprintf('%s, %s', $booking['city'], $booking['area']) ?> </h4>
                                <p><?php echo $booking['description_short'] ?></p>
                            <div class="room-btn">
                                <a class="link-to-page" href="room.php?room_id=<?php echo $booking['room_id']?>&check_in_date=<?php echo $booking['check_in_date']?>&check_out_date=<?php echo $booking['check_out_date'] ?>">Go to room page</a>
                            </div>
                        </main>
                    </article> 
                    <div class="more-info">
                        <div class="per-night-info">
                            <p>Total cost: <?php echo $booking['price'] ?>&euro;</p>
                        </div>
                        <div class="group-more-info">
                            <p>Check-in date: <?php echo $booking['check_in_date'] ?></p>
                            <p> | </p>
                            <p>Check-out date:<?php echo $booking['check_out_date'] ?></p>
                            <p> | </p>
                            <p>Type of Room:<?php echo $booking['room_type'] ?></p>
                        </div>
                    </div>
                    <?php
                        } 
                    ?> 
                    <?php
                        } else {
                    ?>
                    <h4 class="alert-profile"> You don't have any booking!</h4>     
                    <?php
                        } 
                    ?>
                    <hr> 
            </section>
        </section>
      

    </main>

    <!-- Main section ends -->

    <footer>
        <p> &copy; 2021 Copyright Alexander Adam </p> 
    </footer>
  

    <!-- Roboto fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">

    <!-- Sccripts and css -->  
    <link href="assets/css/style-profile.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <script src="assets/js/profile.js"></script>
 </body>
</html>