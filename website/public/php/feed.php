<?php

include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

$output = str_replace("{feed-timeline}",generate_feed_timeline(1),$output); //da sostituire 1 con userId!!
$output = str_replace("{feed-next-releases}",generate_feed_next_releases(1),$output); //da sostituire 1 con userId!!


function generate_feed_next_releases($userId){
    $arrayReleases = Feed::getReleases($userId); 
    if(isset($arrayReleases)){
        $stringToReturn = "";
        foreach($arrayReleases as $release){
            if (is_future_date($release->deadlineDate)){
                $title = $release->mediaName;
                $subtitle = $release->sutitle;
                $coverImage = $release->coverUrl;
                $remainingDays = get_remaining_days($release->deadlineDate);
                $element = "<div class='next-release'>
                                <div class='next-release-image-container'>
                                    <img src='$coverImage' class='cover' alt='immagine copertina'/>
                                </div>
                                <div class='next-release-text-area padding-1 text-align-center'> 
                                    <h4>$title</h4>
                                    <h6>$subtitle</h6>
                                    <p class='next-release-remaining-days'>$remainingDays</p>
                                    <p> giorni rimanenti </p>
                                </div>    
                            </div>";
                $stringToReturn .= $element;
            }
        }
    }
    return $stringToReturn;
}

function generate_feed_timeline($userId){
    $arrayFeed = get_merged_array_date_ordered(get_past_releases(Feed::getReleases($userId)), Feed::getFeed($userId));
    if(isset($arrayFeed)){
        $stringToReturn = "";
        foreach($arrayFeed as $item){
            $title = get_title($item);
            $subtitle = get_subtitle($item);
            $content = get_content($item);
            $date = get_date($item);
            $media = get_media($item);
            $element = "<div class='timeline-container'>
                            <div class='timeline-content'>
                                <div class='timeline-date'>
                                    <p>$date</p> 
                                </div>
                                <div class='timeline-text'>
                                    <h3 xml:lang='en-GB' lang='en-GB'>$title</h3>
                                    <p>$subtitle</p>
                                    <p class='padding-top-0-5'>$content</p>
                                </div>
                            </div>
                                $media
                        </div>";
            $stringToReturn .= $element;
        }
    }
    return $stringToReturn;
}

//se disponibile ritorna il link del trailer altrimenti ritorna foto di copertina
function get_media($feedObj){
    if ($feedObj instanceof Feed){
        $video = $feedObj->videoUrl; 
                    if (isset($video) && $video!=""){ 
                        $media ="<div class='content-justify-right padding-top-1 padding-left-3'>
                                    <object class='timeline-video' data='$video'>trailer 
                                    </object>
                                </div>";
                    }
                    else{
                        $mediaObj = Media::fetch($feedObj->mediaId);
                        $cover = $mediaObj->coverUrl; 
                        $media = "<div class='content-justify-right padding-top-1 padding-left-2'>
                                    <img class='timeline-image' alt='immagine copertina' src='$cover'></img>
                                </div>";
                    }
    }
    else{
        $cover = $feedObj->coverUrl; 
        $media = "<div class='content-justify-right padding-top-1 padding-left-2'>
                    <img class='timeline-image' alt='immagine copertina' src='$cover'></img>
                </div>";
    }
    return $media;
}


function is_future_date($dateToCheck){
    $dteStart = new DateTime($dateToCheck);
    $dteEnd = new DateTime(date("Y-m-d"));
    $dteDiff  = date_diff($dteStart,$dteEnd);
    $diffInDays = (int)$dteDiff->format("%r%a"); //%r da il segno(+,-), %a i giorni
    if ($diffInDays<0){
        return true;
    }
    else{
        return false;
    }
}

function get_remaining_days($date){
    $dteStart = new DateTime($date);
    $dteEnd = new DateTime(date("Y-m-d"));
    $dteDiff  = date_diff($dteStart,$dteEnd);
    return $dteDiff->days;
}


function get_merged_array_date_ordered($array1, $array2){
    $mergedArray =  array_merge($array1,$array2);  
    //ordina le date del mergedArray
    usort($mergedArray, function($a, $b) {
        if($a instanceof Feed && $b instanceof Feed){
            return ($b->eventDate <=> $a->eventDate);
        }
        if($a instanceof Feed && $b instanceof Release){
            return ($b->deadlineDate <=> $a->eventDate);
        }
        if($a instanceof Release && $b instanceof Feed){
            return ($b->eventDate <=> $a->deadlineDate);
        }
        if($a instanceof Release && $b instanceof Release){
            return ($b->deadlineDate <=> $a->deadlineDate);
        }
    });
    return $mergedArray;
}

function get_title($object){
    if ($object instanceof Feed){
        $mediaObj = Media::fetch($object->mediaId);
        return $mediaObj->title;
    }
    else{
        return $object->mediaName;
    }
}

function get_subtitle($object){
    if ($object instanceof Feed){
        return $object->subtitle;
    }
    else{
        return $object->sutitle;
    }
}

function get_content($object){
    if ($object instanceof Feed){
        return $object->content;
    }
    else{
        if($object->isMovie){
            return "L'attesissimo film è finalmente stato rilasciato!";
        }
        else{
            return "Il nuovo episodio è finalmente stato rilasciato!";
        }
    }
}

function get_date($object){
    $mesi = array(1=>'Gennaio', 'Febbraio', 'Marzo', 'Aprile',
                'Maggio', 'Giugno', 'Luglio', 'Agosto',
                'Settembre', 'Ottobre', 'Novembre','Dicembre');
    if ($object instanceof Feed){
        $date = new DateTime($object->eventDate);
    }
    else{
        $date = new DateTime($object->deadlineDate);
    }
    $day = $date->format('j');
    $month = $date->format('n'); //formatta data per prendere il numero del mese che sarà l'indice dell'array mesi (per traduzione italiana)
    return $day.' '.$mesi[$month];
}

// ritorna array con le release la cui data di uscita è già passata
function get_past_releases($arrayReleases){
    $arrayPastRelease = array();
    foreach($arrayReleases as $release){
        if (!is_future_date($release->deadlineDate)){
            array_push($arrayPastRelease,$release);
        }
    }
    return $arrayPastRelease;
}

?>
