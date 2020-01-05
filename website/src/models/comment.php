<?php

include_once("base.php");

class Comment extends Base 
{
    const CONTENT_KEY = "content";
    const USER_ID_KEY = "user_id";
    const MEDIA_ID_KEY = "media_id";
    const USER_FULLNAME_KEY = "user_fullname";


    const TABLE_NAME = "Comment";

    var $content, $userId, $mediaId, $userFullName;
 
    public function __set( $name, $value ) {
        switch ($name)
        {
            case self::CONTENT_KEY: 
                $this->name = $value;
                break;
            case self::USER_ID_KEY: 
                $this->userId = $value;
                break;
            case self::MEDIA_ID_KEY: 
                $this->mediaId = $value;
                break;
            case self::USER_FULLNAME_KEY: 
                $this->userFullName = $value;
                break;
            default: 
                parent::__set($name, $value);
                break;
        }
    }

    public static function getCommentsFor($mediaId)
    {
        $dbman = DBManager::getInstance();
        return $dbman->query("SELECT *, CONCAT(".User::TABLE_NAME.".".User::NAME_KEY.", ' ', ".User::TABLE_NAME.".".User::SURNAME_KEY.") as user_fullname FROM ".self::TABLE_NAME." JOIN ".User::TABLE_NAME." on ".Comment::TABLE_NAME.".".Comment::USER_ID_KEY." = ".User::TABLE_NAME.".".Base::ID_KEY." WHERE ".self::TABLE_NAME.".".self::MEDIA_ID_KEY." = {$mediaId} ORDER BY ".self::TABLE_NAME.".".Base::CREATED_KEY." DESC;", Comment::class);
    }

    public static function createComment($userId, $mediaId, $content)
    {
        $dbman = DBManager::getInstance();
        return $dbman->query("INSERT INTO ".self::TABLE_NAME." (`".self::CONTENT_KEY."`, `".self::USER_ID_KEY."`, `".self::MEDIA_ID_KEY."`) VALUES ('{$content}', {$userId}, {$mediaId})");
    }

    public static function getAvatar($id)
    {
        $dbman = DBManager::getInstance();
        return $dbman->query("SELECT avatar_url FROM User WHERE User.id='$id'");
    }

 }

?>




