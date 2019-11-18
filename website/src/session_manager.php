<?php

session_start(); // move to layout or somewhere else if necessary

class SessionManager
{
    private const USER_ID_KEY = "user_id";
    private const USERNAME_KEY = "username";

    private function __construct()
    {
    }

    public static function starSessionForUser($userId, $username)
    {
        if (is_int($userId) && $userId >= 0 && is_string($username) && !empty($username))
        {
            $_SESSION[SessionManager::USER_ID_KEY] = $userId;
            $_SESSION[SessionManager::USERNAME_KEY] = $username;
            return true;
        }
        return false;
    }

    public static function isUserLogged()
    {
        return isset($_SESSION[SessionManager::USER_ID_KEY]);
    }

    public static function getUserId()
    {
        if (SessionManager::isUserLogged())
            return $_SESSION[SessionManager::USER_ID_KEY];
        return null;
    }

    public static function getUsername()
    {
        if (SessionManager::isUserLogged())
            return $_SESSION[SessionManager::USERNAME_KEY];
        return null;
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
    }
}


?>