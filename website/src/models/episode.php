<?php

include_once("base.php");

class Episode extends Base 
{
    const TITLE_KEY = "title";
    const DESCRIPTION_KEY = "description";
    const PROMO_KEY = "promo_url";
    const MEDIA_ID_KEY = "media_id";
    const SEASON_KEY = "season";
    const NUMBER_KEY = "number";
    const AIR_DATE_KEY = "air_date";

    var $title, $description, $promoUrl, $mediaId, $seasonNum, $episodeNum, $airDate;
 
    public function __set( $name, $value ) {
        switch ($name)
        {
            case self::TITLE_KEY: 
                $this->title = $value;
                break;
            case self::DESCRIPTION_KEY: 
                $this->description = $value;
                break;
            case self::PROMO_KEY: 
                $this->promoUrl = $value;
                break;
            case self::MEDIA_ID_KEY: 
                $this->mediaId = $value;
                break;
            case self::SEASON_KEY: 
                $this->seasonNum = $value;
                break;
            case self::NUMBER_KEY: 
                $this->episodeNum = $value;
                break;
            case self::AIR_DATE_KEY: 
                $this->airDate = $value;
                break;
            default: 
                parent::__set($name, $value);
                break;
        }
    }
 }

?>