<?php

include_once("base.php");

class Feed extends Base 
{
    const TABLE_NAME = "Feed"; 

    const CONTENT_KEY = "content";
    const SUBTITLE_KEY = "subtitle";
    const AUTHOR_ID_KEY = "author_id";
    const MEDIA_ID_KEY = "media_id";
    const EVENT_DATE_KEY = "event_date";
    const VIDEO_URL_KEY = "video_url";

    var $content, $subtitle, $authorId, $mediaId, $eventDate, $videoUrl;
 
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
            case self::VIDEO_URL_KEY: 
                    $this->videoUrl = $value;
                    break;
            default: 
                parent::__set($name, $value);
                break;
        }
    }

    public function saveInDB() {
        $dbman = DBManager::getInstance();
        $insertQuery = "INSERT INTO ".(self::TABLE_NAME)." (".(self::CONTENT_KEY).", ".(self::SUBTITLE_KEY).", ".(self::AUTHOR_ID_KEY).", ".(self::MEDIA_ID_KEY).", ".(self::EVENT_DATE_KEY).", ".(self::VIDEO_URL_KEY).") ";
        $insertQuery .= "VALUES ('".$this->content."', '".$this->subtitle."', ".$this->authorId.", ".$this->mediaId.", '".$this->eventDate."', '".$this->videoUrl."');";

        return $dbman->query($insertQuery);
    }

    public static function getFeed($userId, $lastItemId = null)
    {
        $dbman = DBManager::getInstance();
        $favs = Media::getUserFavourites($userId);

        if (sizeof($favs) == 0) // no favs so no feed
            return [];

        $query = "SELECT * FROM ".Feed::TABLE_NAME." WHERE (1=1";
        foreach ($favs as &$fav) {
            $query .= " OR ".Feed::MEDIA_ID_KEY." = ".$fav->id." ";
        }
        $query .= ")";
        if ($lastItemId != null)
            $query .= " AND id < ".$lastItemId." ";
        $query .= " ORDER BY ".Feed::EVENT_DATE_KEY." DESC";
        return $dbman->query($query, Feed::class);
    }

    public static function getReleases($userId) 
    {
        $releases = [];
        $favs = Media::getUserFavourites($userId);
        foreach ($favs as &$fav) {
            if ($fav->isMovie()) {
                array_push($releases, new Release($fav));
            } else {
                $episodes = Episode::getEpisodesFor($fav->id);
                foreach ($episodes as &$epi) {
                    array_push($releases, new Release($fav, $epi));
                }
            }
        }
        return $releases;
    }
 }

 class Release {
     var $mediaid, $mediaName, $deadlineDate, $subtitle, $isMovie, $coverUrl, $promoUrl, $description;
     var $valid = false;

     public function __construct($media, $episode = null)
    {
        $this->mediaid = $media->id;
        $this->mediaName = $media->title;
        $this->coverUrl = $media->coverUrl;
        
        $this->isMovie = $media->isMovie();
        if ($this->isMovie)
        {
                $this->deadlineDate = $media->airDate;
                $this->subtitle = "Rilascio film";
                $this->valid = true;
                $this->promoUrl = $media->trailerUrl;
                $this->description = $media->description;
        }
        else 
        {
            $this->valid = true;
            $this->deadlineDate = $episode->airDate;
            $this->subtitle = "Stagione ".$episode->seasonNum . " episodio ".$episode->episodeNum;
            $this->promoUrl = $episode->promoUrl;
            $this->description = $episode->description;

        }
        
    }
 }

?>