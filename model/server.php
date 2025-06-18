<?php
require_once('database.php');
class Server
{
    protected $id;
    protected $name;
    protected $icon_url;
    protected $created_at;
    protected $owner_id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getIconUrl()
    {
        return $this->icon_url;
    }

    /**
     * @param $icon_url
     */
    public function setIconUrl($icon_url)
    {
        $this->icon_url = $icon_url;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * @param $owner_id
     */
    public function setOwnerId($owner_id)
    {
        $this->owner_id = $owner_id;
    }

    /******************************************************
     * -------- CREAT A SERVER WITH DEFAULT SERVER --------
     ******************************************************/
    public static function create(Server $server) {
        $db = init_db();
        $req = $db->prepare('INSERT INTO servers (name, icon_url, owner_id, created_at) VALUES (?,?,?,NOW())');
        $req->execute([
            $server->getName(),
            $server->getIconUrl(),
            $server->getOwnerId(),
        ]);
        $server_id = $db->lastInsertId();

        //default channels to be created for each new server
        $defaultChannels = ['General','Random','Music','Games','Help'];

        //create each default channel linked to the new server
        foreach($defaultChannels as $channelName) {
            $req = $db->prepare('INSERT INTO channels (name, server_id , created_at) VALUES (?,?,NOW())');
            $req->execute([$channelName, $server_id]);
        }
        $db = null;
        return $server_id;
    }

    /*******************************************
     * -------- GET THE LIST OF SERVERS --------
     *******************************************/
    public static function getServersForUser($user_id)
    {
        $db = init_db();
        $req = $db->prepare('SELECT * FROM servers WHERE owner_id = ?');
        $req->execute([$user_id]);
        $data = $req->fetch();

        if (!$data) return null;

        $server = new Server();
        $server->setId($data['id']);
        $server->setName($data['name']);
        $server->setIconUrl($data['icon_url']);
        $server->setCreatedAt($data['created_at']);
        $server->setOwnerId($data['owner_id']);

        $db = null;
        return $server;
    }
}