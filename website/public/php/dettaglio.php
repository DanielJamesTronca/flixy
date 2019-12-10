<?php
include_once("../src/db_manager.php");
include_once("../src/models/models.php");
include_once("../src/session_manager.php");


$title="";
$genre="None";
$duration="0";
$cover_url="None";
$description="None";
$season="/";
$episode="/";
$trailer_url="None";



$dbMan = DBManager::getInstance();
$genreList = $dbMan->query("SELECT Genre.name FROM Genre LEFT JOIN Media ON Genre.id = Media.genre");
console_log($genreList);

function console_log ( $data) 
{
echo '<script>';
echo 'console.log(' .json_encode($data).')';
echo '</script>';
}


function loadInfo($id){
    $dbMan = DBManager::getInstance();

    $list=$dbMan->query("SELECT * FROM Media WHERE id='$id'") ;
    $title=$list[0]->name;
    $duration=$list[0]->duration;
    $cover_url=$list[0]->cover_url;
    $description=$list[0]->description;

    $episode=$list[0]->episodes;
    $season=$list[0]->seasons;
    $trailer_url=$list[0]->trailer_url;
   

   

    $arr=array($title,$duration, $cover_url, $description, $episode, $season, $trailer_url);
    
    return $arr;
}

$lista= loadInfo(2);  // $movieId instead of 1

$title=$lista[0];  
$duration=$lista[1];
$cover_url=$lista[2];
$description=$lista[3];
$episode=$lista[4];
$season=$lista[5];
$trailer_url=$lista[6];



?>







