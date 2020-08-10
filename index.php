<?php
session_start();

// Define
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", __DIR__);
define("APP", ROOT.DS."application");
define("VIEW", APP.DS."View");
define("ARCHIVE", ROOT.DS."archives");
define("FIMAGE", ROOT.DS."festivalImages");

// Require
require APP.DS."autoload.php";
require APP.DS."helper.php";
require APP.DS."web.php";