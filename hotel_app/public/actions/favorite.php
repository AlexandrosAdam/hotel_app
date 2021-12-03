<?php

use Hotel\Favorite;
use Hotel\User;
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


// Set room to favorite
$favorite = new Favorite();

// Add or remove room from favorites
$isFavorite = $_REQUEST['is_favorite'];


if (!$isFavorite) {
    $favorite->addFavorite($roomId,  User::getCurrentUserId());
    
} else {
    $favorite->removeFavorite($roomId,  User::getCurrentUserId());
}

// Return to room page
header(sprintf('Location: /hotel_app/public/room.php?room_id=%s', $roomId));





