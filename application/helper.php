<?php
function dump(){
    foreach(func_get_args() as $arg) {
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
}

function user(){
    return isset($_SESSION['user']) ? $_SESSION['user'] : false;
}

function go($url, $message = ""){
    echo "<script>";
    if($message !== "") echo "alert('$message');";
    echo "location.href='$url';";
    echo "</script>";
    exit;
}

function back($message = ""){
    echo "<script>";
    if($message !== "") echo "alert('$message');";
    echo "history.back();";
    echo "</script>";
    exit;
}

function view($viewName, $data = []){
    extract($data);
    $viewName = str_replace("/", DS, $viewName);
    $filePath = VIEW.DS.$viewName.".php";
    if(is_file($filePath)) {
        require VIEW.DS."layouts".DS."header.php";
        require $filePath;
        require VIEW.DS."layouts".DS."footer.php";
    }
}

function json_response($data = []){
    if(!is_array($data)) $data = ["message" => $data];

    header("Content-Type: application/json");
    echo json_encode($data);
    exit;
}

