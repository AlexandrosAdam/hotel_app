<?php
    require __DIR__.'/../boot/boot.php';

    use Hotel\User;


    // User is already connected
    if (!empty(User::getCurrentUserId())){


        // delete the session by clearing the $_SESSION array
        $_SESSION = array();

        // Delete the session cookie by setting its expiration to an hout ago (3600)
        if (isset($_COOKIE['user_token'])) {

            
            setCookie('user_token', '', time() - 3600, '/');

            //Destroy the session
            session_destroy();
        }

        // Return to home page
        header('Location: /hotel_app/public/index.php');
      }

?>