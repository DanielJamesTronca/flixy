<?php

  
  function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }

  function research($input) {
    if ($input) {
        return Media::list(null, $input, null, null, null, "ASC");
    }
  }

  function fillGenreSelect($genreList) {
    $list = [];
    for ($x = 0; $x < count($genreList); $x++) { 
      $genre = $genreList[$x]->name;
      if (isset($_GET["genre-select"])){
        if ($_GET["genre-select"] == $genre) {
          $element = "<option selected value=".$genre.">".$genre."</option>";
        } else {
          $element = "<option value=".$genre.">".$genre."</option>";
        }
      } else {
        $element = "<option value=".$genre.">".$genre."</option>";
      }
      array_push($list, $element);
    }
    return implode($list);
  }
  
  function fillYearSelect($yearList) {
    $list = [];
    for ($x = 0; $x < count($yearList); $x++) { 
      $year = $yearList[$x]->anno;
      if (isset($_GET["year-select"])) {
        if ($_GET["year-select"] == $year) {
          $element = "<option selected value=".$year.">".$year."</option>";
        } else {
          $element = "<option value=".$year.">".$year."</option>";
        }  
      } else {
        $element = "<option value=".$year.">".$year."</option>";
      }
    }
      
      array_push($list, $element);

    return implode($list);
  }

  function filterList($year, $genre, $userId = null) {
    $result = [];
    $genreId = -1;
    if ($genre != "All") {
      $genreId = Genre::getIdGenre($genre)[0]->id;
    }
    if ($year != "All" && $genre != "All") {
      $result = Media::list($userId, null, $year, $genreId, null, "ASC");
    } else if ($year != "All") {
      $result = Media::list($userId, null, $year, null, null, "ASC");
    } else if ($genre != "All") {
      $result = Media::list($userId, null, null, $genreId, null, "ASC");
      console_log($genreId);
    } else {
      $result = Media::list($userId, null,null,null, null, "ASC"); 
    }
    return $result;
  }

  function checkMovie($id) {
    $votedMovies = null;
    if (SessionManager::isUserLogged()) {
      $votedMovies = Media::getUserVotes(SessionManager::getUserId());
    }   
    if ($votedMovies && count($votedMovies)) {
      for ($x = 0; $x < count($votedMovies); $x++) {
        if ($votedMovies[$x]->media_id == $id) {
          switch ($votedMovies[$x]->positive) {
            case 1:
              return 1;
            break;
            case 0:
              return 0;
            break;
          }
        }
      }
      return -1;
    } else {
      return -1;
    }
  }

  function replaceContentsMovieCard($card, $title, $coverUrl, $stars, $id, $votesTotal, $votesPositive, $isFav) {
    $starNumber = [];
    $card = str_replace("{movieTitle}", $title, $card);
    $card = str_replace("{mediaNotFav}", !($isFav == true) ? "" : "hidden", $card);
    $card = str_replace("{mediaIsFav}", ($isFav == true) ? "" : "hidden", $card);
    $card = str_replace("{likes}", $votesPositive, $card);
    $card = str_replace("{dislikes}", $votesTotal-$votesPositive, $card);
    $card = str_replace("{coverURL}", "../public/".$coverUrl, $card);
    $card = str_replace("{movieID}", $id, $card);
    $card = str_replace("{linkDettaglioMovie}", "./php/layout.php?page=dettaglio&movieId=".$id, $card);
    switch(checkMovie($id)) {
      case 1:
        $card = str_replace("{like-selected}", "thumb-selected", $card);
      break;
      case 0:
        $card = str_replace("{dislike-selected}", "thumb-selected", $card);
      break;
      case -1: {
        $card = str_replace("{like-selected}", " ", $card);
        $card = str_replace("{dislike-selected}", " ", $card);
      } break;
    }
    for($i=0;$i<$stars;$i++) {
      array_push($starNumber, "<i class='fa fa-star'></i>");
    }
    $card = str_replace("{movieStars}", implode($starNumber), $card);
    return $card;
  }

  function getMovieList($list) {
    $movieList = [];
    for ($x = 0; $x < count($list); $x++) {
      $card = replaceContentsMovieCard(file_get_contents("../html/movie-card.html"), $list[$x]->title, $list[$x]->coverUrl, $list[$x]->stars, $list[$x]->id, $list[$x]->votesTotal, $list[$x]->votesPositive, $list[$x]->isFavourite);
      array_push($movieList, $card);
    }
    return implode($movieList);
  }
  

?>