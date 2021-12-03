<?php


// Boot application
require_once __DIR__.'/../../boot/boot.php';

use Hotel\User;

// Return to home page if not a get request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'get') {
    header('Location: /');

    return;
}

// Verify User 
$user = new User();
$userTest = $user->verify($_REQUEST['email'], $_REQUEST['password']);


try {

    if (!$user->verify($_REQUEST['email'], $_REQUEST['password'])) {
        var_dump("Inside if statement!");
        header('Location: /login.php?error=Could not verify user');

        return;
        } 
} catch (InvalidArgumentException $ex) {
    if (!$user->verify($_REQUEST['email'], $_REQUEST['password'])) {
        header('Location: /login.php?error=No user exists with given email');

        return;
        } 
}

// Create token as cookie for user, for 30 days
$userInfo = $user->getByEmail($_REQUEST['email']);
$token = $user->getUserToken($userInfo['user_id']);
setCookie('user_token', $token, time() + 60 * 60 * 24 * 30, '/');
// Return to home page
header('Location: /hotel_app/public/index.php');

error_reporting(E_ALL);



