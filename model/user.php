<?php

require_once('database.php');

class User
{
    protected $id;
    protected $email;
    protected $username;
    protected $password;
    protected $avatar_url;
    protected $tag;
    protected $confirmation_token;
    protected $is_confirmed;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getAvatarUrl()
    {
        return $this->avatar_url;
    }

    /**
     * @param mixed $avatar_url
     */
    public function setAvatarUrl($avatar_url)
    {
        $this->avatar_url = $avatar_url;
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return mixed
     */
    public function getConfirmationToken()
    {
        return $this->confirmation_token;
    }

    /**
     * @param mixed $confirmation_token
     */
    public function setConfirmationToken($confirmation_token)
    {
        $this->confirmation_token = $confirmation_token;
    }

    /**
     * @return mixed
     */
    public function getIsConfirmed(){
        return $this->is_confirmed;
    }

    /**
     * @param mixed $is_confirmed
     */
    public function setIsConfirmed($is_confirmed){
        $this->is_confirmed = $is_confirmed;
    }


    /**************************************
     * -------- GET USER DATA BY ID --------
     ***************************************/

    public static function getUserById($id)
    {
        // Open database connection
        $db = init_db();

        $req = $db->prepare("SELECT * FROM users WHERE id = ?");
        $req->execute([$id]);

        // Close database connection
        $db = null;

        return $req->fetch();
    }

    /***************************************
     * ------- GET USER DATA BY USERNAME -------
     ****************************************/

    public static function getUserByCredentials($email, $password)
    {
        // Open database connection
        $db = init_db();

        $req = $db->prepare("SELECT * FROM users WHERE email=? AND password=?");
        $req->execute([
            $email,
            $password
        ]);

        // Close database connection
        $db = null;

        return $req->fetch();
    }

    public static function getFriendsForUser($user_id): array
    {
        // Open database connection
        $db = init_db();

        $req = $db->prepare("SELECT users.* FROM users LEFT JOIN friends ON users.id = friends.friend_user_id WHERE friends.user_id = ?");
        $req->execute([$user_id]);

        // Close database connection
        $db = null;

        return $req->fetchAll();
    }

    public static function findUserWithUsername($username)
    {
        // Open database connection
        $db = init_db();

        $req = $db->prepare("SELECT * FROM users WHERE username = ?");
        $req->execute([$username]);

        // Close database connection
        $db = null;

        return $req->fetch();
    }


    public static function isAlreadyFriend($user_id, $friend_id)
    {
        // Open database connection
        $db = init_db();

        $req = $db->prepare("SELECT COUNT(*) FROM friends WHERE (user_id = ? AND friend_user_id = ?) OR (user_id = ? AND friend_user_id = ?)");
        $req->execute([
            $user_id,
            $friend_id,
            $friend_id,
            $user_id
        ]);

        $isAlreadyFriend = $req->fetchColumn() > 0;

        // Close database connection
        $db = null;

        return $isAlreadyFriend;
    }

    public static function addFriend($user_id, $friend_id)
    {
        // Open database connection
        $db = init_db();

        $req = $db->prepare("INSERT INTO friends VALUES (NULL, ?, ?)");
        $req->execute([
            $user_id,
            $friend_id
        ]);

        $id = $db->lastInsertId();
        // Close database connection
        $db = null;

        return $id;
    }

    /*********************************************
     * ------- CREATE NEW USER IN DATABASE -------
     *********************************************/
    public  static function createUser(User $user)
    {
        //open database connection
        $db = init_db();

        $req = $db->prepare("INSERT INTO users (email,username,password,avatar_url,tag,confirmation_token,is_confirmed) VALUES (?,?,?,?,?,?,?)");
        $req->execute([
            $user->getEmail(),
            $user->getUsername(),
            $user->getPassword(),
            "/static/lib/bootstrap-icons-1.5.0/person-fill.svg",
            $user->getTag(),
            $user->getConfirmationToken(),
            $user->getIsConfirmed()
        ]);

        $id = $db->lastInsertId();
        //close database connection
        $db = null;

        return $id;
    }

    /******************************************
     * ------- CHECK IF USER TAG EXISTS -------
     ******************************************/
    public static function isTagTaken(string $username, string $tag):bool
    {
        $db = init_db();
        $req = $db->prepare("SELECT id FROM users WHERE username=? AND tag=?");
        $req->execute([$username, $tag]);
        $count = $req->fetchColumn();
        $db = null;
        return $count > 0;
    }

    /***********************************************
     * ------- CHECK IF EMAIL IS ALREADY USED -------
     ***********************************************/
    public static function findUserByEmail($email)
    {
        //open database connection
        $db = init_db();

        $req = $db->prepare("SELECT * FROM users WHERE email=?");
        $req->execute([$email]);

        //close database connection
        $db = null;

        return $req->fetch();
    }


    /***************************************************
     * ------- FIND USER BY CONFIRMATION TOKEN --------
     ***************************************************/
    public static function findUserByToken(string $token)
    {
        $db = init_db();
        $req = $db->prepare("SELECT * FROM users WHERE confirmation_token = ?");
        $req->execute([$token]);
        $user = $req->fetch();
        $db = null;
        return $user;
    }

    /******************************************
     * ------- CONFIRM USER ACCOUNT --------
     ******************************************/
    public static function confirmUser(int $id)
    {
        $db = init_db();
        $req = $db->prepare("UPDATE users SET is_confirmed = 1, confirmation_token = NULL WHERE id = ?");
        $req->execute([$id]);
        $db = null;
    }

}
