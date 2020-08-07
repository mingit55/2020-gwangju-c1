<?php
function loadClass($className){
    $className = str_replace("\\", DS, $className);
    $filePath = APP.DS.$className.".php";
    if(is_file($filePath)) require $filePath;
}

spl_autoload_register("loadClass");