<?php
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");
include_once("../../src/session_manager.php");

$title="";
$genre="None";
$duration="0";
$cover_url="None";
$description="None";
$season="/";
$episode="/";
$trailer_url="None";
$stars="0";

$serieTvEpisode="";
$serieTvEpisodeReal="EPISODES:";
$serieTvSeason="";
$serieTvSeasonReal="SEASON:";

$dbMan = DBManager::getInstance();

function loadInfo($id){
  $dbMan = DBManager::getInstance();
  $numeroStelle=[];
  $list=Media::fetch($id);

  $stars=$list->stars;

  for($i=0;$i<$stars;$i++) {
    array_push($numeroStelle, "<i class='fa fa-star'></i>");
  }
  $arr=array($list->title ,$list->duration, $list->coverUrl, $list->description, $list->numEpisodes, 
  $list->numSeasons, $list->trailerUrl, $numeroStelle, $list->genreId, $list->votesPositive,
  $list->votesTotal, $list->airDate, $list->genreId);
  return $arr;
}


$movieId=$_GET["movieId"];
$lista= loadInfo($movieId);


$genre=Genre::getNameGenre($lista[8]);
$genre2=$genre[0]->name;
$episode=$lista[4];
$season=$lista[5];

$likes=$lista[9];
$total_votes=$lista[10];
$data_rilascio=$lista[11];







$output=str_replace("{genre}", $genre2,$output);
$output=str_replace("{mediaid}",$movieId,$output);
$output=str_replace("{title}", $lista[0],$output);
$output=str_replace("{duration}", $lista[1],$output);
$output=str_replace("{cover_url}", "../public/".$lista[2],$output);
$output=str_replace("{description}", $lista[3],$output);
$output=str_replace("{episode}", $lista[4],$output);
$output=str_replace("{season}", $lista[5],$output);
$output=str_replace("{trailer_url}",$lista[6],$output);
$output = str_replace("{movieStars}", implode($lista[7]), $output);
$output = str_replace("{air_date}", $lista[11], $output);






$genre_aux=$genre;

if($episode==null && $season==null){
  $output=str_replace("{serieTvEpisode}", $serieTvEpisode,$output);
  $output=str_replace("{serieTvSeason}", $serieTvSeason,$output);
}
else { 
  $output=str_replace("{serieTvEpisode}", $serieTvEpisodeReal,$output );
  $output=str_replace("{serieTvSeason}", $serieTvSeasonReal,$output );
}

$actualGenre_aux= $lista[8];
$realGenre= Media::getMediasWithGenre($actualGenre_aux);
$genre_variable=Genre::getNameGenre($actualGenre_aux);


function getSimilarMovies($realGenre, $genre_variable) {
  $movieList = [];
  $y=0;

  for ($x = 0; $x < count($realGenre); $x++) {
    if ($realGenre[$x]->id == $_GET["movieId"]) continue;
    $titolo = $realGenre[$x]->title;
    $url = $realGenre[$x]->coverUrl;
    $genre_card=$genre_variable[$y]->name;

    $card = file_get_contents("../html/similar_content_card.html");
    $card = str_replace("{movieTitle}", $titolo, $card);
    $card = str_replace("{movieGenre}", $genre_card, $card);
    $card = str_replace("{movieCover}", "../public/".$url, $card);
    array_push($movieList, $card);
  }
  return implode($movieList);
}



function generate_similar_content($realGenre){
  if(count($realGenre)>1){
    $element_similar_content="<h1 class='primary-color font-size-2-2 padding-left-1 padding-bottom-0-5 text-align-left'>Contenuti simili</h1>";
  }
  else {
    $element_similar_content=NULL;
  }
  return $element_similar_content;
}
$output=str_replace("{similar_content}", generate_similar_content($realGenre),$output );


$trailer_content=$lista[6];
function generate_trailer_content($trailer_content){
  if(($trailer_content)==NULL){
    $element_trailer=NULL;
  }
  else {
    $element_trailer="
    <div id='yt' class='margin-top-2'>
    <h1 class='primary-color font-size-2-2 padding-left-1 padding-bottom-0-5 text-align-left'>Trailer</h1> 
    <object class='video_yt padding-left-2' data='$trailer_content'></object>
    </div>
    ";
  }
  return $element_trailer;
}
$output=str_replace("{trailer}", generate_trailer_content($trailer_content),$output );







$comments=Comment::getCommentsFor($movieId);

function getCommentList($comments) {
  $commentList = [];
  $y=0;

  for ($x = 0; $x < count($comments); $x++) {
    
    $contenuto = $comments[$x]->content;
    $nome_commento=$comments[$x]->userFullName;
    $id_to_url=$comments[$x]->userId;

    $id_to_url_aux=Comment::getAvatar($id_to_url);
    $finally_url=$id_to_url_aux[$y]->avatar_url;
    
    $commento = file_get_contents("../html/comment.html");
    $commento = str_replace("{nome_commento}", $nome_commento, $commento);
    $commento = str_replace("{contenuto_commento}", $contenuto, $commento);
    $commento = str_replace("{avatar_url_commento}", "../public/".$finally_url, $commento);

    array_push($commentList, $commento);
  }
  return implode($commentList);
}


$output = str_replace("{commentList}", getCommentList($comments), $output);
$output = str_replace("{movieList}", getSimilarMovies($realGenre, $genre_variable), $output);

$output=str_replace("{likes}", $likes,$output);
$output=str_replace("{dislikes}", $likes,$output);  //DA FARE C'E' LIKES E NON DISLIKES


?>
