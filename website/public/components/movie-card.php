<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
  <title>movie-card</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="title" content="Flixy - Homepage" />
  <base target="_self" href="http://localhost/flixy/website/public/components">
  <script src="https://kit.fontawesome.com/cfeebd4134.js" type="text/javascript"></script>
<!-- <link rel="stylesheet" type="text/css" href="./assets/rules.css"/> -->
  <link rel="stylesheet" type="text/css" href="./assets/rules.css"/>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&amp;display=swap" rel="stylesheet" type="text/css"/>
<!--<script src="./scripts/movie-card.js" type="text/javascript"></script> -->
</head>
  <body class="primary-bg">
    <div class="movie-entry secondary-bg margin-right-0-6 margin-left-0-6 border-radius-0-5">
      <?php 
        echo '<img id="copertina" class="border-radius-0-5 copertina-size" src=".'.$url.'" alt="copertina"/>';
      ?>

      <h3 id="title" class="full-width text-align-center primary-color font-size-1-5">
        <?php
          echo $title; 
        ?>
      </h3>
     
      <div class="margin-left-0-6 margin-top-1 font-size-1 rating primary-color flex-container flex-content-space-between flex-align-items-center">
          <span id="activeStars" class="stars-active text-align-left">
            <?php
                for($i=0;$i<$stars;$i++) {
                  echo '<i class="fa fa-star"></i>';
                }
            ?>
          </span>
          <button><i id="link-to-book" class="fas fa-chevron-right primary-color font-size-1-5"></i></button>
      </div>
      <span id="num-votes" class="font-weight-bold full-width text-align-center font-size-0-938 primary-color"> </span>
      <div id="thumbs" class="text-align-center primary-color font-size-2-2">
        <a><i id="thumbs-up" class="far fa-thumbs-up"></i></a>
        <a><i id="thumbs-down" class="far fa-thumbs-down"></i></a>
      </div>
      <div id="num-up-down" class="text-align-center primary-color font-size-0-938">
        <span id="num-up">346</span>
        <span id="num-down">153</span>
      </div>
      <div id="fav-section" class="text-align-center primary-color">
        <a><i id="fav-icon" class="fas fa-heart font-size-1-1"></i></a>
        <span id="fav-text" class="text-align-center font-size-0-625">Add to your favourites</span>
      </div>
    </div>
  </body>
</html>

<!-- This page is validated -->