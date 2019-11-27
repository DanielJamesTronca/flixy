<?php
include_once("../src/db_manager.php");
include_once("../src/models/models.php");
include_once("../src/session_manager.php");


$title="";
$genre="None";
$duration="0";
$cover_url="None";
$description="None";
$season="/";
$episode="/";
$trailer_url="None";



$dbMan = DBManager::getInstance();
$genreList = $dbMan->query("SELECT Genre.name FROM Genre LEFT JOIN Media ON Genre.id = Media.genre");
console_log($genreList);

function console_log ( $data) 
{
echo '<script>';
echo 'console.log(' .json_encode($data).')';
echo '</script>';
}


function loadInfo($id){
    $dbMan = DBManager::getInstance();

    $list=$dbMan->query("SELECT * FROM Media WHERE id='$id'") ;
    $title=$list[0]->name;
    $duration=$list[0]->duration;
    $cover_url=$list[0]->cover_url;
    $description=$list[0]->description;

    $episode=$list[0]->episodes;
    $season=$list[0]->seasons;
    $trailer_url=$list[0]->trailer_url;
   

   

    $arr=array($title,$duration, $cover_url, $description, $episode, $season, $trailer_url);
    
    return $arr;
}

$lista= loadInfo(2);  // $movieId instead of 1

$title=$lista[0];  
$duration=$lista[1];
$cover_url=$lista[2];
$description=$lista[3];
$episode=$lista[4];
$season=$lista[5];
$trailer_url=$lista[6];



?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">


<head>
  <title>Flixy - Dettaglio Film</title>
  <meta name="title" content="Flixy - Dettaglio" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="./assets/dettaglio.css"/>
  <script src="https://kit.fontawesome.com/cfeebd4134.js" type="text/javascript"></script>
</head>



<body class="secondary-bg">
<!-- FLEXIBLE GRID -->
<div id="row" class="flex-container flex-wrap ">

  <div id="side" class="flex-container flex-grow-shrink flex-content-center flex-align-items-center secondary-bg ">
<!-- COPERTINA MOVIE -->
        <div id="copertina">
        <?php 
        echo '<img id="copertina" class="border-radius-0-5 copertina-size" src=".'.$cover_url.'" alt="copertina"/>';
        ?>
         </div>
  </div>

<!-- MAIN CONTENT -->
    <div id="main" class="flex-container flex-wrap secondary-bg flex-grow-2 ">
        <div id="info" class="primary-color">
            <h1 id="text" class=" font-size-2-2">Title: <?php echo $title ?></h1>
            
            

            <div id="column" > 

                
                <h2 class="font-size-0-938">Genere: <?php echo $genreList[0]->name ?></h2>   <!-- $movieId instead of 0 -->
                <h2 class="font-size-0-938">Durata: <?php echo $duration ?></h2>

                
                
                <?php 
                    if($episode!=null){ echo '<h1 class= "margin-left-0-5 font-size-0-938">Episodes: '.$episode.' '; }
                ?>

                <?php 
                    if($season!=null){ echo '<h1 class= "margin-left-0-5 font-size-0-938">Seasons: '.$season.' '; }
                ?>
              
                
            </div>
            <div id="fav-section" class="primary-color">
                    <a><i id="fav-icon" class="fas fa-heart font-size-1-7 margin-right-2"></i></a>
            </div>

            <p class=" margin-top-3 "> 
            <?php echo $description ?>
            </p>
      </div>  
    </div> 
</div>

<div id="trailer" class="flex-container flex-grow-shrink flex-content-center flex-align-items-center">
    <div id="yt" class="padding-2" >     
        <h1 class="primary-color font-size-2-2 text-align-center ">Trailer</h1> 
        <?php
        echo '<object data="'.$trailer_url.'" alt="trailer"></object>'
        ?>
    </div>
</div>

<div id="similar" class="flex-container flex-grow-shrink flex-content-start flex-align-items-left">
        <div id="contenuti" class="padding-2" >     
            <h1 class="primary-color font-size-2-2 text-align-left ">Contenuti simili</h1> 
        </div>
    </div>

</body>
</html>



