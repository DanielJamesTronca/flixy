<?php
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");
include_once("../../src/session_manager.php");

$card = file_get_contents("../html/similar_content_card.html");



$title="";
$genre="None";
$cover_url="None";


$dbMan = DBManager::getInstance();
$genreList = $dbMan->query("SELECT Genre.name FROM Genre LEFT JOIN Media ON Genre.id = Media.genre");

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
    $cover_url=$list[0]->cover_url;
    
    $arr=array($title, $cover_url);
    return $arr;
   
}

$movieId=2;

$lista= loadInfo($movieId);  // $movieId instead of 1

$title=$lista[0];
$cover_url=$lista[1];
$genre=$genreList[$movieId-1]->name;







$card=str_replace("{movieTitle}", $title,$card);
$card=str_replace("{movieGenre}", $genre,$card);
$card=str_replace("{movieCover}", "../../public".$cover_url,$card);
console_log($cover_url);


echo $card;

?>




