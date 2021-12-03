<?php

use Hotel\Favorite;
use Hotel\User;

require_once __DIR__.'/../../boot/boot.php';



// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    echo "This is a post script.";
    die;
}

// If there is already logged in user, return to main page
if (empty(User::getCurrentUserId())) {
    echo "No current user.";
    die;
}

// Check if room id is given
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    echo "No room is given fir this operation.";
    die;
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


// Return operation status
echo json_encode([
    'status' => true,
    'is_favorite' => !$isFavorite,
]);
