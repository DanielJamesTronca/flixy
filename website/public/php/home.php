<?php
$genreList = fillGenreSelect(Genre::getGenreList());
$yearList = fillYearSelect(Media::getAirDateList());

$output = str_replace("<option>{genreOption}</option>", $genreList, $output);
$output = str_replace("<option>{yearOption}</option>", $yearList, $output);
$output = str_replace("<option>{typeOption}</option>", fillTypeSelect(), $output);

$displayMovieList = 3;

$varGenre = "All";
$varYear = "All";
$varType = "All";

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

if (isset($_GET["type-select"])) {
  $varType = $_GET['type-select'];
} else {
  $varType = "All";
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
switch($displayMovieList) {
  case 0:
    $result = $varReturnSearch; 
  break;
  case 1: {
    $output = str_replace("{latestSelected}", "highlight-bg", $output);
    $result = Media::list($userId, null,null,null, null, "air_date", "DESC"); 
  } break;
  case 2: { 
    $output = str_replace("{mostVotesSelected}", "highlight-bg", $output);
    $result = Media::list($userId, null,null,null, null, "votes_positive", "DESC"); 
  } break;
  case 3: 
    $result = filterList($varYear, $varGenre, $varType, $userId);
  break;
  default: 
    $result = filterList($varYear, $varGenre, $varType, $userId);
  break;
}

$movieList = getMovieList($result);

if ($movieList != '') {
  $output = str_replace("{movieList}", $movieList, $output);
} else {
  $output = str_replace("{movieList}", "Nessun file multimediale trovato.", $output);
}
?>