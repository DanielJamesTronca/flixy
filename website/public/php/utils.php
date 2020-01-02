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
      $element = "<option value=".$genre.">".$genre."</option>";
      array_push($list, $element);
    }
    return implode($list);
  }
  
  function fillYearSelect($yearList) {
    $list = [];
    for ($x = 0; $x < count($yearList); $x++) { 
      $year = $yearList[$x]->anno;
      $element = "<option value=".$year.">".$year."</option>";
      array_push($list, $element);
    }
    return implode($list);
  }

  function filterList($year, $genre) {
    $result = [];
    $genreId = -1;
    if ($genre != "All") {
      $genreId = Genre::getIdGenre($genre)[0]->id;
    }
    if ($year != "All" && $genre != "All") {
      $result = Media::list(null, null, $year, $genreId, null, "ASC");
    } else if ($year != "All") {
      $result = Media::list(null, null, $year, null, null, "ASC");
    } else if ($genre != "All") {
      $result = Media::list(null, null, null, $genreId, null, "ASC");
      console_log($genreId);
    } else {
      $result = Media::list(null, null,null,null, null, "ASC"); 
    }
    return $result;
  }

  function replaceContentsMovieCard($card, $title, $coverUrl, $stars, $id) {
    $starNumber = [];
    $card = str_replace("{movieTitle}", $title, $card);
    $card = str_replace("{coverURL}", "../public".$coverUrl, $card);
    $card = str_replace("{linkDettaglioMovie}", "./php/layout.php?page=dettaglio&movieId=".$id, $card);
    for($i=0;$i<$stars;$i++) {
      array_push($starNumber, "<i class='fa fa-star'></i>");
    }
    $card = str_replace("{movieStars}", implode($starNumber), $card);
    return $card;
  }

  function getMovieList($list) {
    $movieList = [];
    for ($x = 0; $x < count($list); $x++) {
      $card = replaceContentsMovieCard(file_get_contents("../html/movie-card.html"), $list[$x]->title, $list[$x]->coverUrl, $list[$x]->stars, $list[$x]->id);
      array_push($movieList, $card);
    }
    return implode($movieList);
  }
  

?>