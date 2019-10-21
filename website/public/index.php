<?php 

include_once("../src/db_manager.php");
include_once("../src/models/models.php");

print_r(Media::list(null, null, Media::GENRE_ID_KEY, "ASC"));

?>