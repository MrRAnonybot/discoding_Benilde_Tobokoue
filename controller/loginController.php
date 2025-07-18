<?php

session_start();

require_once('model/user.php');

/****************************
 * ----- LOAD LOGIN PAGE -----
 ****************************/

function loginPage()
{
    $user = new stdClass();
    $user->id = $_SESSION['user_id'] ?? false;
    require('view/loginView.php');
}

/***************************
 * ----- LOGIN FUNCTION -----
 ***************************/

function login($post)
{

    $email = $post['email'];
    //hash the password for comparison
    $password = hash('sha256', $post['password']);
    $user_data = User::getUserByCredentials($email, $password);

    if ($user_data == null) {
        $error_msg = "Email ou mot de passe incorrect";
        require('view/loginView.php');
        return;
    }
    // check for account confirmation
    if(!$user_data['is_confirmed']){
        $error_msg = "please confirm your account before logging in";
        require('view/loginView.php');
        return;
    }

    // Set session
    $_SESSION['user_id'] = $user_data['id'];
    $user_id = $_SESSION['user_id'] ?? false;
    header('location: index.php ');
}

/****************************
 * ----- LOGOUT FUNCTION -----
 ****************************/

function logout()
{
    $_SESSION = array();
    session_destroy();

    header('location: index.php');
}
