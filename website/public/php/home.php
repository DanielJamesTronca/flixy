<?php
$genreList = fillGenreSelect(Genre::getGenreList());
$yearList = fillYearSelect(Media::getAirDateList());

$output = str_replace("{genreOption}", $genreList, $output);
$output = str_replace("{yearOption}", $yearList, $output);

$displayMovieList = 3;

$varGenre = "All";
$varYear = "All";

if (isset($_GET["year-select"])) {
  $varYear = $_GET['year-select'];
} else {
  $varYear = "All";
}

if (isset($_GET["genre-select"])){
  $varGenre = $_GET['genre-select'];
} else {
  $varGenre = "All";
}

if (isset($_GET["getMovies"])) {
  switch($_GET["getMovies"]) {
    case "latest":
      $displayMovieList = 1;
    break;
    case "mostVotes":
      $displayMovieList = 2;
    break;
  }
}

if ($varSearch) {
  $displayMovieList = 0;
}

$userId = null;
if (SessionManager::isUserLogged()) {
  $userId = SessionManager::getUserId();
}
$userId = 2;
switch($displayMovieList) {
  case 0:
    $result = $varReturnSearch; 
  break;
  case 1: 
    $result = Media::list($userId, null,null,null, "air_date", "DESC"); 
  break;
  case 2: 
    $result = Media::list($userId, null,null,null,"votes_positive", "DESC"); 
  break;
  case 3: 
    $result = filterList($varYear, $varGenre);
  break;
  default: 
    $result = filterList($varYear, $varGenre);
  break;
}
// print_r($result);
$movieList = getMovieList($result);
if ($movieList != '') {
  $output = str_replace("{movieList}", $movieList, $output);
} else {
  $output = str_replace("{movieList}", "Nessun file multimediale trovato.", $output);
}

?>