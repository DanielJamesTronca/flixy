<?php

include_once("base.php");

class Feed extends Base 
{
    const CONTENT_KEY = "content";
    const SUBTITLE_KEY = "subtitle";
    const AUTHOR_ID_KEY = "author_id";
    const MEDIA_ID_KEY = "media_id";
    const EVENT_DATE_KEY = "event_date";

    var $content, $subtitle, $authorId, $mediaId, $eventDate;
 
    public function __set( $name, $value ) {
        switch ($name)
        {
            case self::CONTENT_KEY: 
                $this->content = $value;
                break;
            case self::SUBTITLE_KEY: 
                $this->subtitle = $value;
                break;
            case self::AUTHOR_ID_KEY: 
                $this->authorId = $value;
                break;
            case self::MEDIA_ID_KEY: 
                $this->mediaId = $value;
                break;
            case self::EVENT_DATE_KEY: 
                $this->eventDate = $value;
                break;
            default: 
                parent::__set($name, $value);
                break;
        }
    }
 }

?>