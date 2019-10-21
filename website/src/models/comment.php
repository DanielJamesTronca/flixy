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
        return $dbman->query("SELECT * FROM ".self::TABLE_NAME." WHERE ".self::TABLE_NAME.".".self::MEDIA_ID_KEY." = {$mediaId} ORDER BY ".self::TABLE_NAME.".".Base::CREATED_KEY." ASC;", Comment::class);
    }
 }

?>