<?php
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

$output = file_get_contents("../html/feed.html"); //DA TOGLIERE per far funzionare layout
$output = str_replace("{feed-timeline}",generate_feed_timeline(1),$output); //da sostituire 1 con userId!!
$output = str_replace("{feed-next-releases}",generate_feed_next_releases(1),$output); //da sostituire 1 con userId!!
echo $output; //DA TOGLIERE per non far stampare due volte quando richiamato da layout

generate_feed_next_releases(1);

function generate_feed_next_releases($userId){
    $arrayReleases = Feed::getReleases($userId); 
    if(isset($arrayReleases)){
        $stringToReturn = "";
        foreach($arrayReleases as $release){
            $title = $release->mediaName;
            $subtitle = $release->sutitle;
            $isMovie = $release->isMovie;
            $coverImage = $release->coverUrl;
            $deadlineDate = $release->deadlineDate;
            $dteStart = new DateTime($deadlineDate);
            $dteEnd = new DateTime(date("Y-m-d"));
            $dteDiff  = $dteStart->diff($dteEnd);
            $dteDiff = $dteDiff->format("%D");
           
            $element = "<div class='next-release'>
                            <div class='next-release-image-container'>
                                <img src=$coverImage class='cover' alt='immagine copertina'/>
                            </div>
                            <div class='next-release-text-area padding-1 text-align-center'> 
                                <h4>$title</h4>
                                <h6>$subtitle</h6>
                                <p class='next-release-remaining-days'> $dteDiff </p>
                                <p> giorni rimanenti </p>
                            </div>    
                        </div>";
            $stringToReturn .= $element;
        }
    }
    return $stringToReturn;

}


function generate_feed_timeline($userId){
    $arrayFeed = Feed::getFeed($userId); 
        if(isset($arrayFeed)){
            $stringToReturn = "";
            foreach($arrayFeed as $item){
                $mediaObj = Media::fetch($item->mediaId);
                $title = $mediaObj->title;
                $subtitle = $item->subtitle;
                $content = $item->content;

                $date = new DateTime($item->eventDate);
                $day = $date->format('j');
                $month = $date->format('n'); //formatta data per prendere il numero del mese che sarà l'indice dell'array mesi (per traduzione italiana)
                $mesi = array(1=>'Gennaio', 'Febbraio', 'Marzo', 'Aprile',
                'Maggio', 'Giugno', 'Luglio', 'Agosto',
                'Settembre', 'Ottobre', 'Novembre','Dicembre');

                $media = get_media($item, $mediaObj);
                $element = "<div class='timeline-container'>
                                <div class='timeline-content'>
                                    <div class='timeline-date'>
                                        <p>$day $mesi[$month]</p> 
                                    </div>
                                    <div class='timeline-text'>
                                        <h3 xml:lang='en-GB' lang='en-GB'> $title </h3>
                                        <p> $subtitle </p>
                                        <p class='padding-top-0-5'> $content </p>
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
function get_media($feedObj, $mediaObj){
    $video = $feedObj->videoUrl; 
                if (isset($video)){ 
                    $media ="<div class='content-justify-right padding-top-1 padding-left-3'>
                                <object class='timeline-video' data=$video alt='trailer'> 
                                </object>
                            </div>";
                }
                else{
                    $cover = $mediaObj->coverUrl; 
                    $media = "<div class='content-justify-right padding-top-1 padding-left-2'>
                                <img src=$cover class='timeline-image' alt='cover image'></img>
                            </div>";
                }
    return $media;
}

?>