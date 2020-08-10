<?php
use Core\Router;

Router::get("/", "MainController@homePage");
Router::get("/notice", "MainController@noticePage");
Router::get("/exchange-guide", "MainController@exchangePage");
Router::get("/major-festival", "MainController@majorFestivalPage");

/**
 * API
 */

Router::get("/api/festivals", "APIController@getFestivals");
Router::get("/api/exchanges", "APIController@getExchanges");

Router::get("/xml/insert-database", "APIController@insertDatabaseXML");

Router::connect();