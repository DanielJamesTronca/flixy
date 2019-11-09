<?php
session_start();

include_once("../src/db_manager.php");
include_once("../src/models/models.php");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
  <title>Flixy - Homepage</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="title" content="Flixy - Homepage" />
  <script src="https://kit.fontawesome.com/cfeebd4134.js" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" href="./assets/home.css"/>
  <link rel="stylesheet" type="text/css" href="./assets/rules.css"/>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&amp;display=swap" rel="stylesheet" type="text/css"/>
</head>
  <body class="document-font">
      <div id="filters-menu">

        <ul id="general-filters">
          <li class="filter filters-text medium-margin-left">Latest</li>
          <li class="filter filters-text medium-margin-left">Most votes</li>
        </ul>

        <div class="menu-divider"></div>

        <div id="dropdown-select" class="primary-color">
          <div id="year-filter" class="margin-left-1">
            <label id="year-label" for="year-select" class="primary-color margin-left-1">Year</label>
            <select id="year-select" class="margin-left-0-5">
              <option>op1</option>
              <option>op1</option>
              <option>op1</option>
              <option>op1</option>
              <option>op1</option>
            </select>
          </div>
          <div id="genre-filter">  
            <label id="genre-label" for="genre-select" class="margin-left-1">Genre</label>
            <select id="genre-select" class="margin-left-0-5">
                <option>op1</option>
                <option>op1</option>
                <option>op1</option>
                <option>op1</option>
                <option>op1</option>
            </select>
          </div>  
        </div>



      <div id="movies-container">
      </div>
      </div>
  </body>
</html>

<!-- This page is validated -->

<!-- This page is validated -->