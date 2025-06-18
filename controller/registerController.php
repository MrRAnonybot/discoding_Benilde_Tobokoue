<?php

require_once('model/user.php');

/************************************
 * ------- LOAD REGISTER PAGE -------
 ************************************/

function registerPage()
{
    require ('view/registerView.php');
}

/******************************
 * ------- TAG FUNCTION -------
 *****************************/


function generateUniqueTag($username){
    for ($i =1; $i<=9999; $i++) {
        $tag = str_pad(strval(rand(0, 9999)),4,"0",STR_PAD_LEFT);
        if(!user::isTagTaken($username,$tag)){
            return $tag;
        }
    }
    throw new Exception("unable to generate unique tag");
}

/***********************************
 * ------- REGISTER FUNCTION -------
 ***********************************/

function register($post)
{
    $email = trim($post['email']);
    $username = trim($post['username']);
    $password = $post['password'];
    $confirm_password = $post['confirm_password'];
    $tag = generateUniqueTag($username);
    //generate a unique confirmation token
    $confirmation_token = bin2hex(random_bytes(32)); // 64-character hex string
    $is_confirmed = 0;

    //confirmation link
    $confirmation_link = "http://localhost/index.php?action=confirm&token=". $confirmation_token;
    //mail structure
    $subject = "Confirm your Discoding account";
    $message = "Hello " . $username . ",\n\nClick this link to confirm your account:\n" . $confirmation_link;
    $headers = "From: no-reply@discoding.com";
    //mail($email, $subject, $message, $headers);


    //check if passwords match
    if ($password !== $confirm_password) {
        $erorr_msg = "Passwords do not match";
        require('view/registerView.php');
        return;
    }

    //check if email is already taken
    $existing_user = User::findUserByEmail($email);
    if ($existing_user) {
        $erorr_msg = "An account already exists with this email address.";
        require('view/registerView.php');
        return;
    }

    //create user
    $user = new User();
    $user->setEmail($email);
    $user->setUsername($username);
    //hash the password
    $hashedPassword = hash('sha256', $post['password']);
    $user->setPassword($hashedPassword);
    $user->setTag($tag);
    $user->setConfirmationToken($confirmation_token);
    $user->setIsConfirmed($is_confirmed);

    $user_id =  User::createUser($user);

    //login the user
    //$_SESSION['user_id'] = $user_id;

    //token in the url to be easily accesible to be use in the link int the message "link http://localhost/index.php?action=confirm&token="
    header("Location: /index.php?action=confirm&message=" . urlencode("Your account has been created. Please confirm your email") ."/". $confirmation_token);
    exit;
}