<?php
use Core\Router;

/**
 * Pages
 */

Router::get("/", "MainController@homePage");
Router::get("/notice", "MainController@noticePage");
Router::get("/exchange-guide", "MainController@exchangePage");
Router::get("/major-festival", "MainController@majorFestivalPage");
Router::get("/location", "MainController@locationPage");
Router::get("/festivals", "FestivalController@festivalPage");
Router::get("/festivals/images-tar", "FestivalController@downloadImageTar");
Router::get("/festivals/images-zip", "FestivalController@downloadImageZip");
Router::get("/festivals/details", "FestivalController@detailPage");
Router::get("/schedules", "FestivalController@schedulePage");

/**
 * Action
 */
Router::post("/sign-in", "MainController@signIn");
Router::get("/logout", "MainController@logout", "user");
Router::post("/festivals", "FestivalController@writeFestival", "user");
Router::put("/festivals", "FestivalController@editFestival", "user");
Router::delete("/festivals", "FestivalController@removeFestival", "user");
Router::post("/festivals/reviews", "FestivalController@writeReview");
Router::delete("/festivals/reviews", "FestivalController@removeReview", "user");


/**
 * API
 */

Router::get("/api/festivals", "APIController@getFestivals");
Router::get("/api/festival", "APIController@getFestival");
Router::get("/api/exchanges", "APIController@getExchanges");

Router::get("/openAPI/festivalList.php", "APIController@getFestivalsByMonth");
Router::get("/xml/insert-database", "APIController@insertDatabaseXML");

Router::connect();