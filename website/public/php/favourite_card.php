<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
<base target="_self" href="http://localhost/flixy/website/public/"> <!--da cambiare!!!! -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no"> <!-- per ottimizzazione visualizzazione smartphone -->
<link rel="stylesheet" media="screen" type="text/css" href="prova.css"/>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&amp;display=swap" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="action.js"></script>
<title>Flixy - Favourite Card</title>
<meta name="title" content="Flixy - Favoutire card" />
</head>






  <body>
    <div class="movie-entry">

      <div class="movie">
      
      <?php 
        echo '<img id="copertina" class="border-radius-medium copertina-size" src=".'.$url.'" alt="copertina"/>';
      ?>

      



      </div>

      <div id="genere" class="text-color-white margin-top-small">
            <h1 id="text" class="margin-left-small font-medium-normal">Title</h1> 
            <?php
              echo $nome; 
            ?>
            <h2 id="text" class="margin-left-medium-small font-small">Genere</h2>
            <?php
              echo $genere; 
            ?>
      </div>
      

      <div id="fav-section" class="text-color-white">
        <a><i id="fav-icon" class="fas fa-heart font-huge"></i></a>
      </div>
      
      
      
    </div>
  </body>
</html>

