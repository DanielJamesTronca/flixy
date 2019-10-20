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

    var $title, $description, $coverUrl, $genreId, $genreName, $stars, $duration, $hasEpisodes, $numEpisodes, $numSeasons, $trailerUrl, $airDate;
 
    public function __set( $name, $value ) {
        switch ($name)
        {
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
 }

?>