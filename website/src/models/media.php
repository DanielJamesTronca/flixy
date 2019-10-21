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
    const TRAILER_KEY = "trailer_key";
    const DATE_KEY = "air_date";
    const VOTES_TOTAL_KEY = "votes_count";
    const VOTES_POSITIVE_KEY = "votes_positive";

    const TABLE_NAME = "Media";

    var $title, $votesTotal, $votesPositive, $description, $coverUrl, $genreId, $genreName, $stars, $duration, $hasEpisodes, $numEpisodes, $numSeasons, $trailerUrl, $airDate;
 
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


    public static function list($name=null, $year = null, $genre = null, $order = null, $asc = "ASC")
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

        $queryString = "SELECT *, count(Vote.id) AS votes_count, sum(Vote.positive) as votes_positive, ".(Genre::TABLE_NAME).".name as genre_name FROM ".(self::TABLE_NAME)." LEFT JOIN Vote ON (".(self::TABLE_NAME).".id=Vote.media_id) LEFT JOIN ".(Genre::TABLE_NAME)." ON ".(Genre::TABLE_NAME).".id = ".(self::TABLE_NAME).".genre WHERE ".$whereClause." GROUP BY Media.id {$orderClause};";

        $results = $dbman->query($queryString, Media::class);
        return $results;
    }

    public static function fetch($id)
    {
        $dbman = DBManager::getInstance();
        return $dbman->fetchObject(Media::class, $id);
    }
 }

?>