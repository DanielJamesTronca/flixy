<?php
include_once("../../src/db_manager.php");
include_once("../../src/models/models.php");
include_once("../../src/session_manager.php");

$output = file_get_contents("../html/profilo.html");


$dbMan = DBManager::getInstance();

if(SessionManager::isUserLogged()){
$userId=session_manager::getUerId();




}

