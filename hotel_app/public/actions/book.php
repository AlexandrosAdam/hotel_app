<?php

use Hotel\Booking;
use Hotel\User;

require_once __DIR__.'/../../boot/boot.php';

// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    header('Location: /');

    return;
}

// If there is already logged in user, return to main page
if (empty(User::getCurrentUserId())) {
    header('Location: /');
    return;
}

// Check if room id is given
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    header('Location: /');
    return;
}

// Create booking 
$booking = new Booking();
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$booking->insert($roomId, User::getCurrentUserId(), $checkInDate, $checkOutDate);

// Return to room page
header(sprintf('Location: /hotel_app/public/room.php?room_id=%s&check_in_date=%s&check_out_date=%s', $roomId, $checkInDate, $checkOutDate));


error_reporting(E_ERROR);


