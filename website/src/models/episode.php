<?php

include_once("base.php");

class Episode extends Base 
{
    const TABLE_NAME = "Episode";
    const TITLE_KEY = "title";
    const DESCRIPTION_KEY = "description";
    const PROMO_KEY = "promo_url";
    const MEDIA_ID_KEY = "media_id";
    const SEASON_KEY = "season";
    const NUMBER_KEY = "number";
    const AIR_DATE_KEY = "air_date";

    var $title, $description, $promoUrl, $mediaId, $seasonNum, $episodeNum, $airDate, $aired;
 
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
                $this->aired = $this->airDate < date("Y-m-d");
                
                break;
            default: 
                parent::__set($name, $value);
                break;
        }
    }

    public function saveInDB() {
        $dbman = DBManager::getInstance();
        $insertQuery = "INSERT INTO ".(self::TABLE_NAME)." (".(self::TITLE_KEY).", ".(self::DESCRIPTION_KEY).", ".(self::PROMO_KEY).", ".(self::MEDIA_ID_KEY).", ".(self::SEASON_KEY).", ".(self::NUMBER_KEY).", ".(self::AIR_DATE_KEY).") ";
        $insertQuery .= "VALUES ('".$this->title."', '".$this->description."', '".$this->promoUrl."', ".$this->mediaId.", ".$this->seasonNum.", ".$this->episodeNum.", '".$this->airDate."');";

        return $dbman->query($insertQuery);
    }

    public static function getEpisodesFor($mediaId)
    {
        $dbman = DBManager::getInstance();
        return $dbman->query("SELECT * FROM ".Episode::TABLE_NAME." WHERE ".Episode::MEDIA_ID_KEY." = ".$mediaId, Episode::class);
    }
 }

?>