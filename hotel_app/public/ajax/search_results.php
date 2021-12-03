<?php
    require __DIR__.'/../../boot/boot.php';


    use Hotel\Room;
    use Hotel\RoomType;

    error_reporting(E_ERROR);

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
    $count_of_guests = $_REQUEST['count_of_guests'];
  
    // Search for room
    $allAvainableRooms = $room->search(new DateTime($checkInDate), new DateTime($checkOutDate), $selectedCity, $price1, $price2, $count_of_guests, $selectedTypeId);
    

?>

<section>
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
        
