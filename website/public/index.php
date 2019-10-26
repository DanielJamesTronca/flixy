<?php 

include_once("../src/db_manager.php");
include_once("../src/models/models.php");

$user = User::getLoggedUser();
$user->name = "Test";
print_r($user->saveUser());

?>