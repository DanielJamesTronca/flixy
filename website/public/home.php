<?php
include_once("../src/db_manager.php");
include_once("../src/models/models.php");
include_once("../src/session_manager.php");

$dbMan = DBManager::getInstance();

$yearList = $dbMan->query("SELECT DISTINCT YEAR(air_date) as anno FROM Media");
$genreList = $dbMan->query("SELECT DISTINCT Genre.name FROM Genre LEFT JOIN Media ON Genre.id = Media.genre");

$varGenre = "All";
$varYear = "All";


function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

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

function fillYearSelect($yearList) {
  for ($x = 0; $x < count($yearList); $x++) { 
    echo '<option value="'.$yearList[$x]->anno.'">'.$yearList[$x]->anno.'</option>';
  }
}

function fillGenreSelect($genreList) {
  for ($x = 0; $x < count($genreList); $x++) { 
    echo '<option value="'.$genreList[$x]->name.'">'.$genreList[$x]->name.'</option>';
  }
}

function getMovieList($list) {
  for ($x = 0; $x < count($list); $x++) {
    $title = $list[$x]->name;
    $url = $list[$x]->cover_url;
    $stars = $list[$x]->stars;
    include("./components/movie-card.php");
  }
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
  <title>Flixy - Homepage</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <base target="_self" href="http://localhost/flixy/website/public/">
  <meta name="title" content="Flixy - Homepage" />
  <script src="https://kit.fontawesome.com/cfeebd4134.js" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" href="./assets/rules.css"/>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&amp;display=swap" rel="stylesheet" type="text/css"/>
</head>
  <body class="document-font primary-bg layout-body">
      <div id="filters-menu" class=" margin-top-2 full-width flex-container flex-content-center flex-align-items-center flex-wrap">
        <ul id="general-filters" class="full-height text-align-center primary-color font-size-0-938 font-weight-bold flex-container flex-content-center flex-items-center flex-align-items-center">
          <li class="filter border-radius-0-3 margin-left-1 padding-left-1-5 padding-right-1-5 padding-top-0-4 padding-bottom-0-4">
            Latest
          <li class="filter border-radius-0-3 margin-left-1 padding-left-1-5 padding-right-1-5 padding-top-0-4 padding-bottom-0-4">
            Most votes
          </li>
        </ul>
        <div class="menu-divider"></div>
        <div id="dropdown-select" class="full-height primary-color text-align-center flex-container flex-content-start flex-items-center flex-align-items-center">
          <form name="year" action="" method="POST" class="flex-container flex-content-start flex-items-center flex-align-items-center">
            
            <div id="year-filter" class="margin-left-1">
              <label id="year-label" for="year-select" class="primary-color margin-left-1">Year</label>
              <select name="year-select" id="year-select" class="custom-select margin-left-0-5 primary-color font-size-0-938 font-weight-bold">
                <option value="All">All</option>
                <?php
                  fillYearSelect($yearList);
                  if (isset($_POST["year-select"])) {
                    $varYear = $_POST['year-select'];   
                  } else {
                    $varYear = "All";
                  }
                  
                ?>
              </select>
            </div>
            
            <div id="genre-filter"> 
              <label id="genre-label" for="genre-select" class="margin-left-1">Genre</label>
              <select name="genre-select" id="genre-select" class="custom-select margin-left-0-5 primary-color font-size-0-938 font-weight-bold">
                <option value="All">All</option>
                  <?php    
                    fillGenreSelect($genreList);
                    if (isset($_POST["genre-select"])){
                      $varGenre = $_POST['genre-select'];
                    } else {
                      $varGenre = "All";
                    }
                  ?>
              </select>
            </div>
            
            <button type="submit" name="submit"  class="margin-left-1-5 custom-button font-size-0-938 font-weight-bold padding-0-3 border-radius-0-3">Filter</button>
          </form>
          
          
        </div>
      
      </div>
      <div id="movies-container" class="full-size flex-container flex-content-center flex-items-center flex-wrap margin-top-2">
        <?php 
          if ($varSearch) {
            $result = $varReturnSearch;
          } else {
            $result = filterList($varYear, $varGenre);
          }
          getMovieList($result);
        ?>
      </div>
  </body>
</html>

<?php


?>

<!-- This page is validated -->