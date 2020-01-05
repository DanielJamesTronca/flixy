<?php

include_once("base.php");

class Media extends Base 
{
    const NAME_KEY = "name";
    const DESCRIPTION_KEY = "description";
    const COVER_KEY = "cover_url";
    const GENRE_ID_KEY = "genre";
    const GENRE_FETCHED_KEY = "genre_name";
    const STARS_KEY = "stars";
    const DURATION_KEY = "duration";
    const HAS_EPISODES_KEY = "hasEpisodes";
    const EPISODES_NUM_KEY = "episodes";
    const SEASONS_NUM_KEY  = "seasons";
    const TRAILER_KEY = "trailer_url";
    const DATE_KEY = "air_date";
    const VOTES_TOTAL_KEY = "votes_count";
    const VOTES_POSITIVE_KEY = "votes_positive";

    const TABLE_NAME = "Media";

    var $title, $votesTotal, $votesPositive, $description, $coverUrl, $genreId, $genreName, $stars, $duration, $hasEpisodes, $numEpisodes, $numSeasons, $trailerUrl, $airDate, $isFavourite = false;
 
    public function __set( $name, $value ) {
        switch ($name)
        {
            case self::VOTES_TOTAL_KEY: 
                $this->votesTotal = $value;
                break;
            case self::VOTES_POSITIVE_KEY: 
                $this->votesPositive = $value;
                break;
            case self::NAME_KEY: 
                $this->title = $value;
                break;
            case self::DESCRIPTION_KEY: 
                $this->description = $value;
                break;
            case self::COVER_KEY: 
                $this->coverUrl = $value;
                break;
            case self::GENRE_ID_KEY: 
                $this->genreId = $value;
                break;
            case self::GENRE_FETCHED_KEY: 
                $this->genreName = $value;
                break;
            case self::STARS_KEY: 
                $this->stars = $value;
                break;
            case self::DURATION_KEY: 
                $this->duration = $value;
                break;
            case self::HAS_EPISODES_KEY: 
                $this->hasEpisodes = $value;
                break;
                case self::EPISODES_NUM_KEY: 
                $this->numEpisodes = $value;
                break;
            case self::SEASONS_NUM_KEY: 
                $this->numSeasons = $value;
                break;
            case self::TRAILER_KEY: 
                $this->trailerUrl = $value;
                break;
            case self::DATE_KEY: 
                $this->airDate = $value;
                break;
            default: 
                parent::__set($name, $value);
                break;
        }
    }

    public function saveInDB() {
        $dbman = DBManager::getInstance();
        $insertQuery = "INSERT INTO ".(self::TABLE_NAME)." (".(self::NAME_KEY).", ".(self::DESCRIPTION_KEY).", ".(self::COVER_KEY).", ".(self::GENRE_ID_KEY).", ".(self::STARS_KEY).", ".(self::DURATION_KEY).", ".(self::HAS_EPISODES_KEY).", ".(self::EPISODES_NUM_KEY).", ".(self::SEASONS_NUM_KEY).", ".(self::TRAILER_KEY).", ".(self::DATE_KEY).") ";
        $insertQuery .= "VALUES ('".$this->title."', '".$this->description."', '".$this->coverUrl."', ".$this->genreId.", ".$this->stars.", ".$this->duration.", ".$this->hasEpisodes.", ".$this->numEpisodes.", ".$this->numSeasons.", '".$this->trailerUrl."', '".$this->airDate."');";
    
        return $dbman->query($insertQuery);
    }

    public function updateInDB() {
        $dbman = DBManager::getInstance();
        $insertQuery = "UPDATE ".(self::TABLE_NAME)." SET  ".(self::NAME_KEY)."='".$this->title."', ".(self::DESCRIPTION_KEY)."='".$this->description."', ".(self::COVER_KEY)."='".$this->coverUrl."', ".(self::GENRE_ID_KEY)."=".$this->genreId.", ".(self::STARS_KEY)."=".$this->stars.", ".(self::DURATION_KEY)."=".$this->duration.", ".(self::HAS_EPISODES_KEY)."=".$this->hasEpisodes.", ".(self::EPISODES_NUM_KEY)."=".$this->numEpisodes.", ".(self::SEASONS_NUM_KEY)."=".$this->numSeasons.", ".(self::TRAILER_KEY)."='".$this->trailerUrl."', ".(self::DATE_KEY)."='".$this->airDate."' ";
        $insertQuery .= " WHERE id=".$this->id;
        return $dbman->query($insertQuery);
    }

    public static function list($userId=null, $name=null, $year = null, $genre = null, $order = null, $asc = "ASC")
    {
        $dbman = DBManager::getInstance();
        $whereClause = "1 ";
        if ($year != null)
            $whereClause = $whereClause." AND YEAR(".(self::TABLE_NAME).".".self::DATE_KEY.") = {$year}";

        if ($genre != null)
            $whereClause = $whereClause." AND ".(self::TABLE_NAME).".".self::GENRE_ID_KEY." = {$genre}";

        if ($name != null)
            $whereClause = $whereClause." AND ".(self::TABLE_NAME).".".self::NAME_KEY." LIKE '%{$name}%'";

        $orderClause = "";
        if ($order != null)
        {
            $orderClause = " ORDER BY {$order} {$asc} ";
        }

        $queryString = "SELECT Media.id, Media.name, Media.description, Media.cover_url, Media.genre, Media.stars, Media.hasEpisodes, Media.episodes, Media.seasons, Media.trailer_url, Media.created_at, Media.updated_at, Media.air_date, count(Vote.id) AS votes_count, sum(Vote.positive) as votes_positive, ".(Genre::TABLE_NAME).".name as genre_name FROM ".(self::TABLE_NAME)." LEFT JOIN Vote ON (".(self::TABLE_NAME).".id=Vote.media_id) LEFT JOIN ".(Genre::TABLE_NAME)." ON ".(Genre::TABLE_NAME).".id = ".(self::TABLE_NAME).".genre WHERE ".$whereClause." GROUP BY Media.id {$orderClause};";
        $results = $dbman->query($queryString, Media::class);
        return Media::setFavouritesFor($userId, $results);
    }

    public static function setFavouritesFor($userId, $medias)
    {
        if ($userId == null) 
            return $medias;
        $dbman = DBManager::getInstance();
        $queryString = "SELECT * FROM Favourite WHERE Favourite.user_id = {$userId}";
        $favourites = $dbman->query($queryString);

        foreach ($favourites as &$fav) {
            foreach ($medias as &$media) {
                if ($media->id == $fav->media_id)
                {
                    $media->isFavourite = true;
                }
            }
        }
        return $medias;
    }

    public static function getUserFavourites($userId)
    {
        $dbman = DBManager::getInstance();
        $queryString = "SELECT * FROM Favourite JOIN ".Media::TABLE_NAME." ON Favourite.media_id = ".Media::TABLE_NAME.".id WHERE Favourite.user_id = {$userId}";
        $results = $dbman->query($queryString, Media::class);
        return $results;
    }

    public static function getUserVotes($userId) {
        $dbman = DBManager::getInstance();
        return $dbman->query("SELECT * FROM Vote WHERE user_id ={$userid}");
    }

    public function setFavourite($userId, $activate)
    {
        $dbman = DBManager::getInstance();
        $mediaId = $this->id;
        if ($activate)
        {
            // set as favourite
            $result = $dbman->query("INSERT INTO Favourite(`user_id`, `media_id`) VALUES ({$userId}, {$mediaId})");
            return $result;
        } else {
            // remove from favourite
            $result = $dbman->query("DELETE FROM Favourite WHERE Favourite.user_id = {$userId} AND Favourite.media_id = {$mediaId}");
            return $result;
        }
    }

    public static function fetch($id)
    {
        $dbman = DBManager::getInstance();
        return $dbman->fetchObject(Media::class, $id);
    }

    public static function getAirDateList() 
    {
        $dbman = DBManager::getInstance();
        return $dbman->query("SELECT DISTINCT YEAR(air_date) as anno FROM Media");
    }

    public static function addVote($userId, $mediaId, $vote) 
    {
        $dbman = DBManager::getInstance();
        $result = $dbman->query("SELECT * FROM VOTES WHERE user_id = {$userId} AND media_id = {$mediaId}");

        if ($result) {
            if ($result[0]->positive != $vote) {
                $dbman->query("UPDATE `vote` SET positive={$vote} WHERE user_id = {$userId} AND media_id = {$mediaId}");
            }
        } else {
            $dbman->query("INSERT INTO `vote` (`id`, `user_id`, `media_id`, `created_at`, `updated_at`, `positive`) VALUES (NULL, {$userid}, {$mediaId}, current_timestamp(), current_timestamp(), {$vote})");
        }
    }
 }

?>