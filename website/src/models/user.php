<?php

include_once("base.php");

class User extends Base 
{
    const NAME_KEY = "name";
    const SURNAME_KEY = "surname";
    const EMAIL_KEY = "email";
    const AVATAR_KEY = "avatar_url";

    var $name, $surname, $email, $avatarUrl;

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
 }

?>