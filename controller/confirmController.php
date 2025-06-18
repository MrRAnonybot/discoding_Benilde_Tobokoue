<?php

require_once('model/user.php');

/*********************************************
 * ------- CONFIRM USER ACCOUNT PAGE --------
 *********************************************/

function confirmAccount()
{
    $token = $_GET['token'] ?? null;

    if (!$token) {
        $confirmation_message = "An email has been sent click on the link to verify your account link: http://localhost/index.php?action=confirm&token=";
        require('view/confirmationView.php');
        return;
    }
    $user = User::findUserByToken($token);
    if (!$user) {
        $confirmation_message = "Token invalid or has expired";
        require('view/confirmationView.php');
        return;
    }
    User::confirmUser($user['id']);

    $confirmation_message = "your account has been verify";
    require('view/confirmationView.php');
}

