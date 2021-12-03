<?php

// Boot application
require_once __DIR__.'/../../boot/boot.php';


use Hotel\User;



// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {

    header('Location: /');

    return;
}

// Create new user ($_REQUEST or $_POST its the same thing)
$user = new User();
// Check if email is given
$selectedEmail = $_REQUEST['email'];

$user->getByEmail($selectedEmail);


if (!empty($user)){
    
    $user->insert($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['password']);
    // Retrieve user
    $userInfo = $user->getByEmail($_REQUEST['email']);

    // Generate token
    $token = $user->getUserToken($userInfo['user_id']);

    // Set cookie
    setcookie('user_token', $token, time() + (30 * 24 * 60 * 60), '/');
    // Return to home page
    header('Location: /hotel_app/public/index.php');

} else {

    echo "Email already taken. Choose another one.";
}


