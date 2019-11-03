<?php 

include_once("../src/db_manager.php");
include_once("../src/models/models.php");

$hashedPassword = hash('sha256', "password");
print_r(DBManager::getInstance()->login("test", $hashedPassword));
?>