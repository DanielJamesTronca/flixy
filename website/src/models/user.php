<?php

include_once("base.php");

class User extends Base 
{
    const NAME_KEY = "name";
    const SURNAME_KEY = "surname";
    const EMAIL_KEY = "email";
    const AVATAR_KEY = "avatar_url";

    var $name, $surname, $email, $avatarUrl, $username;

    const TABLE_NAME = "User";
 
    public function __set( $name, $value ) {
        switch ($name)
        {
            case self::NAME_KEY: 
                $this->name = $value;
                break;
            case self::SURNAME_KEY: 
                $this->surname = $value;
                break;
            case self::EMAIL_KEY: 
                $this->email = $value;
                break;
            case self::AVATAR_KEY: 
                $this->avatarUrl = $value;
                break;
            default: 
                parent::__set($name, $value);
                break;
        }
    }

    public static function getLoggedUser()
    {
        // TODO: get userid if user logged
        $userId = 1;
        $dbman = DBManager::getInstance();
        $result = $dbman->fetchObject(User::class, $userId);
        if ($result)
        {
            $result->username = "fakeusername"; //TODO: get from session
        }
        return $result;
    }

    public function saveUser()
    {
        $dbman = DBManager::getInstance();
        $queryString = "UPDATE ".User::TABLE_NAME." SET ".User::NAME_KEY."='{$this->name}', ".User::SURNAME_KEY."='{$this->surname}', ".User::EMAIL_KEY."='{$this->email}' WHERE id = {$this->id};";
        $result = $dbman->query($queryString, Media::class);
        return $result;
    }
 }

?>