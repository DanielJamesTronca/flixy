<?php
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");

$output = file_get_contents("../html/feed.html");
$output = str_replace("{feed-timeline}",generate_feed_timeline(1),$output); //da sostituire 1 con userId!!
echo $output;


function generate_feed_timeline($userId){
    $arrayFeed = Feed::getFeed($userId); 
        if(isset($arrayFeed)){
            $stringToReturn = "";
            for ($i = 0; $i < sizeof($arrayFeed); $i++){
                $title = "La Casa Di Carta"; //da convertire in $arrayFeed[$i]->title appena viene risolta la mancanza del titolo nell'oggetto
                $subtitle = $arrayFeed[$i]->subtitle;
                $content = $arrayFeed[$i]->content;
                $cover = 'assets/images/covers/casa.jpg'; //da sostituire con $arrayFeed[$i]->cover_url
                $media = get_media($arrayFeed, $i);
                $element = "<div class='timeline-container'>
                                <div class='timeline-content'>
                                    <div class='timeline-date'>
                                        <p>12 Agosto</p>
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
function get_media($array, $index){
    $video = 'https://www.youtube.com/embed/yL1f8yNxGBk'; //da sostituire con $array[$index]->trailer_key
                if (isset($video)){ 
                    $media ="<div class='content-justify-right padding-top-1 padding-left-3'>
                                <object class='timeline-video' data=$video alt='trailer'> 
                                </object>
                            </div>";
                }
                else{
                    $media = "<div class='content-justify-right padding-top-1 padding-left-2'>
                                <img src=$cover class='timeline-image' alt='cover image'></img>
                            </div>";
                }
    return $media;
}

?>