<?php
include_once ("../../src/db_manager.php");
include_once ("../../src/models/models.php");
include_once ("../../src/session_manager.php");

$dbMan = DBManager::getInstance();
$res = $dbMan->login("gaggi", "password1");
print_r($res);
?>