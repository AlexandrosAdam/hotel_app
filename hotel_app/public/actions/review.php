<?php

use Hotel\User;
use Hotel\Review;
use Hotel\Room;


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

// Verify crsf
$crsf = $_REQUEST['crsf'];
if (empty($crsf) || !User::verifyCrsf($crsf)) {
    echo "This is an invalid request";
    return;
}


// Add review
$review = new Review();
$review->insert($roomId, User::getCurrentUserId(), $_REQUEST['rate'], $_REQUEST['comment']);



header(sprintf('Location: /hotel_app/public/room.php?room_id=%s', $roomId));
