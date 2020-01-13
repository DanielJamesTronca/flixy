<?php
  
  function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }

  function research($input) {
    if ($input) {
      if (SessionManager::isUserLogged()) {
        return Media::list(SessionManager::getUserId(), $input, null, null, 2, null, "ASC");
      } else {
        return Media::list(null, $input, null, null, 2, null, "ASC");
      }
    }
  }

  function fillGenreSelect($genreList) {
    $list = [];
    for ($x = 0; $x < count($genreList); $x++) { 
      $genre = $genreList[$x]->name;
      if (isset($_GET["genre-select"])) {
        if ($_GET["genre-select"] == $genre) {
          $element = "<option selected value='".$genre."'>".$genre."</option>";
        } else {
          $element = "<option value='".$genre."'>".$genre."</option>";
        }
      } else {
        $element = "<option value='".$genre."'>".$genre."</option>";
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
          $element = "<option value='".$year."'>".$year."</option>";
        }  
      } else {
        $element = "<option value='".$year."'>".$year."</option>";
      }
      array_push($list, $element);
    }
    return implode($list);
  }

  function fillTypeSelect() {
    $type1 = "Film";
    $type2 = "Serie";
    if (isset($_GET["type-select"])) {
      if ($_GET["type-select"] == $type1) {
        $element = "<option selected value='".$type1."'>".$type1."</option>"."<option value='".$type2."'>".$type2."</option>";
      } 
      if ($_GET["type-select"] == $type2) {
        $element = "<option value='".$type1."'>".$type1."</option>"."<option selected value='".$type2."'>".$type2."</option>";
      }  
      if ($_GET["type-select"] == "All") {
        $element = "<option value='".$type1."'>".$type1."</option>"."<option value='".$type2."'>".$type2."</option>";
      }
    } else {
      $element = "<option value='".$type1."'>".$type1."</option>"."<option value='".$type2."'>".$type2."</option>";
    }

    return $element;
  }

  function filterList($year, $genre, $type, $userId = null) {
    $genreId = null;
    $typeId = null;
    if ($genre != "All") {
      $genreId = Genre::getIdGenre($genre)[0]->id;
    }
    switch ($type) {
      case "Film":
        $typeId = 0;
      break;
      case "Serie":
        $typeId = 1;
      break;
    }
    return Media::list($userId, null, ($year != "All" ? $year : null), ($genre != "All" ? $genreId : null), ($type != "All" ? $typeId : 2), null, "ASC");
  }

  function checkMovie($id) {
    $votedMovies = null;
    if (SessionManager::isUserLogged()) {
      $userId = SessionManager::getUserId();
      $votedMovies = Media::getUserVotes($userId);
    }   
    if ($votedMovies != null) {
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
    if ($votesPositive == null) {
      $card = str_replace("{likes}", 0, $card);
    } else {
      $card = str_replace("{likes}", $votesPositive, $card);
    }
    $movie = Media::fetch($id);
    if ($movie->hasEpisodes == 1) {
      $card = str_replace("{isMovie}", "Serie", $card);
    } else {
      $card = str_replace("{isMovie}", "Film", $card);
    }
    $card = str_replace("{movieTitle}", $title, $card);
    $card = str_replace("{mediaNotFav}", !($isFav == true) ? "" : "hidden", $card);
    $card = str_replace("{mediaIsFav}", ($isFav == true) ? "" : "hidden", $card);
    $card = str_replace("{dislikes}", $votesTotal-$votesPositive, $card);
    $card = str_replace("{coverURL}", "../public/".$coverUrl, $card);
    $card = str_replace("{movieID}", $id, $card);
    $card = str_replace("{linkDettaglioMovie}", "./php/layout.php?page=dettaglio&amp;movieId=".$id, $card);
    $check = checkMovie($id);
    switch($check) {
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
    if (!is_array($list)) {
      $list = [];
    }
    for ($x = 0; $x < count($list); $x++) {
      $card = replaceContentsMovieCard(file_get_contents("../html/movie-card.html"), $list[$x]->title, $list[$x]->coverUrl, $list[$x]->stars, $list[$x]->id, $list[$x]->votesTotal, $list[$x]->votesPositive, $list[$x]->isFavourite);
      array_push($movieList, $card);
    }
    return implode($movieList);
  }
  

?>