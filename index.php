<?php

date_default_timezone_set('Europe/Paris');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('controller/conversationController.php');
require_once('controller/friendController.php');
require_once('controller/loginController.php');
require_once('controller/registerController.php');
require_once('controller/confirmController.php');
require_once('controller/serverController.php');

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'login':
            if (!empty($_POST)) {
                login($_POST);
            } else {
                loginPage();
            }
            break;

        case 'logout':
            logout();
            break;

        case 'conversation':
            conversationPage();
            break;

        case 'friend':
            friendPage();
            break;

        case 'register':
            if (!empty($_POST)) {
                register($_POST);
            } else {
                registerPage();
            }
            break;

        case 'confirm':
            confirmAccount();
            break;

        case 'createServer':
            if (!empty($_POST)) {
                createServer($_POST);
            } else {
                require('view/serverCreationView.php');
            }
            break;

        case 'server':
            if (isset($_GET['id'])) {
                displayServer((int)$_GET['id']);
            }
            break;

    }
} else {
    $user_id = $_SESSION['user_id'] ?? false;

    if ($user_id) {
        friendPage();
    } else {
        loginPage();
    }
}
