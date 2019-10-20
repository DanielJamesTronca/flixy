<?php

class User extends Base 
{
    const NAME_KEY = "name";
    const SURNAME_KEY = "surname";
    const EMAIL_KEY = "email";
    const AVATAR_KEY = "avatar_url";

    var $name, $surname, $email, $avatarUrl;
 
    function __construct()
    {
        parent::__construct(true, "green");
    }

 }

?>