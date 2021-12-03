<?php
    require __DIR__.'/../boot/boot.php';
    

    use Hotel\Favorite;
    use Hotel\Room;
    use Hotel\User;
    use Hotel\Review;
    use Hotel\Booking;

    // Initialize Room service
    $room = new Room();
    $favorite = new Favorite();

    // Check for room id
    $roomId = $_REQUEST['room_id'];
    if (empty($roomId)){
        header('Location: index.php');
        return;
    }

    // Load room info
    $roomInfo = $room->get($roomId);

    

    if (empty($roomInfo)){
        header('Location: index.php');
        return;
    }

    // Get current user id
    $userId = User::getCurrentUserId();

    // Check if rooms is favorite for current user
    $isFavorite = $favorite->isFavorite($roomId, $userId); 

    
    
    
    // Load all room reviews
    $review = new Review();
    $allReviews = $review->getReviewsByRoom($roomId);
  
    
    
    // Check for booking room
    $checkInDate = $_REQUEST['check_in_date'];
    $checkOutDate = $_REQUEST['check_out_date'];
    $alreadyBooked = empty($checkInDate) || empty($checkOutDate);
    
    if (!$alreadyBooked) {
        // Look for bookings
        $booking = new Booking();
        $isBooked = $booking->isBooked($roomId, $checkInDate, $checkOutDate);
    }

    
    error_reporting(E_ALL);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">

    <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" >

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
                        if (empty($userId)) {
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
        <section class="main-container">
            <section class="head-info">
                <div class="hotel-name-reviews">
                    <p class="name-text"> <?php echo sprintf('%s - %s, %s', $roomInfo['name'], $roomInfo['city'], $roomInfo['area'])?> | <p>
                </div>
                <div class="title-reviews"> 
                    <span>Reviews:</span>
                    <?php 
                        $roomAvgReview = $roomInfo['avg_reviews'];

                        for ($i = 1; $i <=5; $i++) {
                            if ($roomAvgReview >= $i) {
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
                    |
                </div>    
                    
                <div class="title-reviews" id="favorite">
                    <form name = "favoriteForm" method = "POST"  class = "favoriteForm" action = "actions/favorite.php"> 
                        <input type="hidden" name="room_id"  value="<?php echo $roomId; ?>">
                        <input type="hidden" name="is_favorite" value="<?php echo $isFavorite  ? '1' : '0'; ?>">
                            <button type="submit" class="fa fa-heart star <?php echo $isFavorite  ? 'selected' : ''; ?>" id="fav"></button>  
                    </form>
                </div>

                <div class="money-text">Per Night: <?php echo $roomInfo['price'] ?>&euro; </div>
            </section>



            <div class="hotel-img">
                <img src="assets/images/<?php echo $roomInfo['photo_url'] ?>" alt="room image">
            </div>

            <section class="more-hotel-information">
                <div class="num-of-guests">
                    <i class="fas fa-user"> <?php echo sprintf('%s', $roomInfo['count_of_guests'])?> </i>
                    <p> COUNT OF GUESTS </p>
                </div>
                <div class="room-type">
                    <i class="fas fa-bed"> <?php echo sprintf('%s', $roomInfo['type_id'])?> </i>
                    <p> TYPE OF ROOM </p>
                </div>
                <div class="hotel-parking">
                    <i class="fas fa-parking"> <?php echo sprintf('%s', $roomInfo['parking'] == 1 ? 'Yes' : 'No')?></i>
                    <p> PARKING </p>
                </div>
                <div class="hotel-wifi">
                    <i class="fas fa-wifi"> <?php echo sprintf('%s', $roomInfo['wifi'] == 1 ? 'Yes' : 'No')?> </i>
                    <p style="margin-left: 28%;"> WIFI </p>
                </div>
                <div class="pet-friendly">
                    <i class="fas fa-dog"> <?php echo sprintf('%s', $roomInfo['pet_friendly'] == 1 ? 'Yes' : 'No')?> </i>
                    <p > PET FRIENDLY </p>
                </div>
            </section>

            <section class="hotel-description">
                <h3>
                    Room Description
                </h3>
                <p><?php echo sprintf('%s', $roomInfo['description_long'])?></p>

                <!-- Booked and already booked button -->
                <?php
                    if ($isBooked) {
                ?>
                <span disabled class="already-book-btn"> Already Booked</span>
                <?php
                    } else {
                ?>
                <!-- Form for checking if a room is booked -->
                <form name="bookingForm" class="bookingForm" method="POST" action="actions/book.php">
                    <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
                    <input type="hidden" name="check_in_date" value="<?php echo $checkInDate; ?>">
                    <input type="hidden" name="check_out_date" value="<?php echo $checkOutDate; ?>">
                    <input type="hidden" name="crsf" value="<?php echo User::getCrsf(); ?>">
                    <button class="book-btn" type="submit">Book Now</button>
                </form>
                    <?php
                    } 
                ?>
            </section>  

            <!-- Location of the hotel -->
            <section class="hotel-location"> 
                    <div id="map"></div>
                    <script>
                        mapboxgl.accessToken = 'YOUR ACCESS TOKEN';
                        const map = new mapboxgl.Map({
                            container: 'map', // container ID
                            style: 'mapbox://styles/mapbox/streets-v11', // style URL
                            center: [<?php echo $roomInfo['location_long'] ?>, <?php echo $roomInfo['location_lat']?>], // starting position [lng, lat]
                            zoom: 13, // starting zoom
                            });
                            
                        let geojson = {
                            type: 'FeatureCollection',
                            features: [{
                                type: 'Feature',
                                geometry: {
                                    type: 'Point',
                                    coordinates: [<?php echo $roomInfo['location_long'] ?>, <?php echo $roomInfo['location_lat']?>]
                                },
                                properties: {
                                    title: 'Mapbox',
                                    description: 'Hotel'
                                }
                            }]
                        };
                        // add markers to map
                        geojson.features.forEach(function(marker){

                            // create a HTML element for each feature
                            let el = document.createElement('div');
                            el.className = 'marker';

                            //make a marker for each feature and add to the map
                            new mapboxgl.Marker(el)
                                .setLngLat(marker.geometry.coordinates)
                                .addTo(map);
                        });

                    </script>   
            </section>

            <!-- Review section  -->
            <section class="hotel-review">
                <h3>
                    Reviews
                </h3>
                <div id="room-reviews-container">
                    <?php

                        foreach($allReviews as $counter => $review) {
                        
                    ?>
                    <div class="room-reviews">
                        <h4>
                            <span><?php echo sprintf('%d. %s', $counter + 1, $review['user_name'])?> </span>
                            <div class="div-reviews">
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
                            </div>
                        </h4> 
                        <h5>Created at: <?php echo $review['created_time'] ?> </h5>
                        <p> <?php echo htmlentities($review['comment']) ?> </p>
                    </div>
                    <?php
                        }
                    ?>
                </div>
                <hr> 
                <h3 style="margin-bottom: -2%;"> Add review </h3>
                <form class="reviewForm" name="reviewForm" method="POST" action="actions/review.php">
                    <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
                    <input type="hidden" name="crsf" value="<?php echo User::getCrsf(); ?>">
                    <h4>
                        <fieldset class="star-widget">
                            <input type="radio" id="star5" name="rate" value="5"><label class="fas fa-star" 
                            for="star5" title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4" name="rate" value="4"><label class="fas fa-star" 
                            for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3" name="rate" value="3"><label class="fas fa-star" 
                            for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2" name="rate" value="2"><label class="fas fa-star" 
                            for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1" name="rate" value="1"><label class="fas fa-star" 
                            for="star1" title="Sucks big time - 1 stars"></label>
                        </fieldset>
                    </h4>
                    <br>
                    <textarea name="comment" id="reviewField" class="comment-area" placeholder="Review.."
                    data-validation-required-message="Please enter a review."></textarea>
                    <button class="review-btn" type="submit"> Submit </button>
                </form>


            </section>
            <!-- Scroll to top button  -->
            <button class="scroll-top">
                <i class="fas fa-arrow-up"></i>
            </button>
        </section>
    </main>

    <!-- Main section ends -->

    <footer>
        <p> &copy; 2021 Copyright Alexander Adam </p> 
    </footer>

    <link rel="stylesheet" type="text/css" href="assets/css/style-room.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link  href="assets/css/fontawesome.min.css" rel="stylesheet">


    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

    <script src="assets\js\room.js"></script>
    
   

 </body>
</html>