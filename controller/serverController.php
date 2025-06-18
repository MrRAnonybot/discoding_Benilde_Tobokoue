<?php

require "model/server.php";

function createServer($post){
    $user_id = $_SESSION['user_id'] ?? false;
    if (!$user_id) {
        header('location: index.php?action=login');
        return;
    }

    $name = trim($post['server_name'] ?? '');
    $icon_url = "/static/img/discordgray.png";
    $server_id = Server::create($name, $user_id, $icon_url);

    header("Location: index.php?action=server&id=$server_id");
}