<?php

//$output = file_get_contents("../html/home.html");
$dbMan = DBManager::getInstance();
function fillGenreSelect($genreList) {
  $list = [];
  for ($x = 0; $x < count($genreList); $x++) { 
    $genre = $genreList[$x]->name;
    $element = "<option value=".$genre.">".$genre."</option>";
    array_push($list, $element);
  }
  return implode($list);
}

$queryGenre = $dbMan->query("SELECT DISTINCT Genre.name FROM Genre LEFT JOIN Media ON Genre.id = Media.genre");
$genreList = fillGenreSelect($queryGenre);
$output = str_replace("{genreOption}", $genreList, $output);

function fillYearSelect($yearList) {
  $list = [];
  for ($x = 0; $x < count($yearList); $x++) { 
    $year = $yearList[$x]->anno;
    $element = "<option value=".$year.">".$year."</option>";
    array_push($list, $element);
  }
  return implode($list);
}

$varGenre = "All";
$varYear = "All";

if (isset($_POST["year-select"])) {
  $varYear = $_POST['year-select'];   
} else {
  $varYear = "All";
}

if (isset($_POST["genre-select"])){
  $varGenre = $_POST['genre-select'];
} else {
  $varGenre = "All";
}


// Populate movie List
function getIdGenre($genre) {
  $dbMan = DBManager::getInstance();
  $result = $dbMan->query("SELECT id FROM Genre WHERE Genre.name = '$genre'");
  return (int)$result[0]->id;
}

function filterList($year, $genre) {
  $dbMan = DBManager::getInstance();
  $result = [];
  $genreId = -1;
  if ($genre != "All") {
    $genreId = getIdGenre($genre);
  }

  if ($year != "All" && $genre != "All") {
    $result = $dbMan->query("SELECT * FROM Media WHERE genre=$genreId AND YEAR(air_date)=$year");
  } else if ($year != "All") {
    $result = $dbMan->query("SELECT * FROM Media WHERE YEAR(air_date)=$year");
  } else if ($genre != "All") {
    $result = $dbMan->query("SELECT * FROM Media WHERE genre=$genreId");
  } else {
    $result = $dbMan->query("SELECT * FROM Media");
  }
  
  return $result;
}

function getMovieList($list) {
  $movieList = [];
  $starNumber = [];
  for ($x = 0; $x < count($list); $x++) {
    $title = $list[$x]->name;
    $url = $list[$x]->cover_url;
    $stars = $list[$x]->stars;
    $id = $list[$x]->id;
    $card = file_get_contents("../html/movie-card.html");
    $card = str_replace("{movieTitle}", $title, $card);
    $card = str_replace("{coverURL}", "../public".$url, $card);
    $card = str_replace("{linkDettaglioMovie}", "./dettaglio.php?id='".$id."'", $card);
    for($i=0;$i<$stars;$i++) {
      array_push($starNumber, "<i class='fa fa-star'></i>");
    }
    $card = str_replace("{movieStars}", implode($starNumber), $card);
    array_push($movieList, $card);
    $starNumber = [];
  }
  return implode($movieList);
}

if ($varSearch) {
  $result = $varReturnSearch;
} else {
  $result = filterList($varYear, $varGenre);
}

$movieList = getMovieList($result);
$output = str_replace("{movieList}", $movieList, $output);

function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}


$queryYear = $dbMan->query("SELECT DISTINCT YEAR(air_date) as anno FROM Media");
$yearList = fillYearSelect($queryYear);
$output = str_replace("{yearOption}", $yearList, $output);
?>
