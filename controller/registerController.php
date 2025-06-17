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

    $user_id =  User::createUser($user);

    //login the user
    $_SESSION['user_id'] = $user_id;

    //redirect to home
    header('location: index.php');
}