<?php

class Server {
    public static function create($name, $owner_id, $icon_url) {
        $db = init_db();
        $req = $db->prepare('INSERT INTO servers (name, icon_url, owner_id, created_at) VALUES (?,?,?,NOW())');
        $req->execute([$name, $icon_url, $owner_id]);
        $server_id = $db->lastInsertId();

        //
        $defaultChannels = ['General','Random','Music','Games','Help'];
        foreach($defaultChannels as $channelName) {
            $req = $db->prepare('INSERT INTO channels (name, server_id , created_at) VALUES (?,?,NOW())');
            $req->execute([$server_id, $server_id]);
        }
        $db = null;
        return $server_id;
    }
}