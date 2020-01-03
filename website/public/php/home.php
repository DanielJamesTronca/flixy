<?php
$genreList = fillGenreSelect(Genre::getGenreList());
$yearList = fillYearSelect(Media::getAirDateList());

$output = str_replace("{genreOption}", $genreList, $output);
$output = str_replace("{yearOption}", $yearList, $output);

$displayMovieList = 3;

$varGenre = "All";
$varYear = "All";

if (isset($_POST["year-select"])) {
  $varYear = $_POST['year-select'];
  unset($_GET);
} else {
  $varYear = "All";
}

if (isset($_POST["genre-select"])){
  $varGenre = $_POST['genre-select'];
  unset($_GET);
} else {
  $varGenre = "All";
}

if (isset($_POST["gen-filters"])) {
  switch($_POST["gen-filters"]) {
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
    $result = Media::list($userId, null,null,null, null, "ASC"); 
  break;
  case 2: 
    $result = Media::list($userId, null,null,null, null, "ASC"); 
  break;
  case 3: 
    $result = filterList($varYear, $varGenre);
  break;
  default: 
    $result = filterList($varYear, $varGenre);
  break;
}
print_r($result);
$movieList = getMovieList($result);
$output = str_replace("{movieList}", $movieList, $output);
?>