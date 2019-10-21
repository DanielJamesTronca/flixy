<?php 

include_once("../src/db_manager.php");
include_once("../src/models/models.php");

print_r(Comment::createComment(1, 1, "Da codice"));

?>