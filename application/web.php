<?php
use Core\Router;

Router::get("/", "MainController@homePage");

Router::get("/major-festival", "MainController@majorFestivalPage");

Router::connect();