<?php

require_once("model/server.php");

/**************************************
 * ------- SERVER PAGE ENTRY POINT -------
 **************************************/
function serverPage()
{
    $user_id = $_SESSION['user_id'] ?? false;
    if (!$user_id) {
        require('view/loginView.php');
        return;
    }

    $action = $_GET['sub_action'] ?? 'detail'; // default to detail view

    switch ($action) {
        case 'detail':
        default:
            displayServer($user_id);
            break;
    }
}
/****************************************
 * ------- DISPLAY SERVER PAGE ---------
 ****************************************/
function displayServer($user_id)
{
    $server_id = $_GET['id'] ?? null;
    if (!$server_id) {
        echo "Invalid server ID";
        return;
    }

    $server = Server::getById($server_id);
    $channels = Server::getChannelsForServer($server_id);
    $messages = Server::getMessagesForChannel($channels[0]['id'] ?? null); // default to first channel

    require_once('view/serverListViewPartial.php');
    $server_list_partial = $server_list_partial ?? '';

    require('view/serverView.php'); // you'll need to create this
}



/**************************************
 * ------- SERVER CREATION FORM -------
 **************************************/
function createServer($post){
    $user_id = $_SESSION['user_id'] ?? false;
    //redirect to login if user is not authenticated
    if (!$user_id) {
        header('location: index.php?action=login');
        return;
    }

    $name = trim($post['server_name'] ?? '');
    if (!$name){
        echo "server name is required";
        return;
    }
    $server = new Server();
    $server->setName($name);
    $server->setIconUrl("/static/img/discordgray.png");
    $server->setOwnerId($user_id);

    $servers_list_partial = serverListPartial($user_id);
    $server_id = Server::create($server);

    header("Location: index.php?action=server&id=$server_id");
}

/******************************************************
 * ------- GET PARTIAL FOR SERVER ICON LIST ----------
 ******************************************************/
function serverListPartial($user_id)
{
    $servers = Server::getServersForUser($user_id);
    $server_list_partial = '';
    require('view/serversListViewPartial.php');
    return $server_list_partial;
}