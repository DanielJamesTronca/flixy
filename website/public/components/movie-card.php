<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
  <title>movie-card</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="title" content="Flixy - Homepage" />
  <base target="_self" href="http://localhost/flixy/website/public/components">
  <script src="https://kit.fontawesome.com/cfeebd4134.js" type="text/javascript"></script>
<!-- <link rel="stylesheet" type="text/css" href="./assets/rules.css"/> -->
  <link rel="stylesheet" type="text/css" href="./assets/movie-card.css"/>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&amp;display=swap" rel="stylesheet" type="text/css"/>
<!--<script src="./scripts/movie-card.js" type="text/javascript"></script> -->
</head>
  <body>
    <div class="movie-entry">
      <?php 
        echo '<img id="copertina" class="border-radius-medium copertina-size" src=".'.$url.'" alt="copertina"/>';
      ?>

      <h3 id="title" class="text-color-white font-big">
        <?php
          echo $title; 
        ?>
      </h3>
     
      <div class="font-medium-normal rating margin-left-medium-small text-color-white">
          <span id="activeStars" class="stars-active">
            <?php
                for($i=0;$i<$stars;$i++) {
                  echo '<i class="fa fa-star"></i>';
                }
            ?>
          </span>
          <i id="link-to-book" class="fas fa-chevron-right text-color-white"></i>
      </div>
      <span id="num-votes" class="text-align-center font-medium-small text-color-white"> </span>
      <div id="thumbs" class="text-align-center text-color-white font-huge">
        <a><i id="thumbs-up" class="far fa-thumbs-up"></i></a>
        <a><i id="thumbs-down" class="far fa-thumbs-down"></i></a>
      </div>
      <div id="num-up-down" class="text-align-center text-color-white font-medium-small">
        <span id="num-up">346</span>
        <span id="num-down">153</span>
      </div>
      <div id="fav-section" class="text-align-center text-color-white">
        <a><i id="fav-icon" class="fas fa-heart font-medium-big"></i></a>
        <span id="fav-text" class="text-align-center font-smaller">Add to your favourites</span>
      </div>
    </div>
  </body>
</html>

<!-- This page is validated -->