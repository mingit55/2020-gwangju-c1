<?php
function dump(){
    foreach(func_get_args() as $arg) {
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
}

function isLogin(){
    return isset($_SESSION['isLogin']);
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
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function checkEmpty(){
    foreach($_POST as $input){
        if(trim($input) == "" || $input == false) back("모든 정보를 입력해 주세요.");
    }
}

function pager($page, $data){
    define("LEN_PAGE", 5);
    define("LEN_ARTICLE", 10);

    $totalArticle = count($data);
    $totalPage = ceil($totalArticle / LEN_ARTICLE);

    $currentBlock = ceil($page / LEN_PAGE);
    $start = $currentBlock * LEN_PAGE - LEN_PAGE + 1;
    if($start < 1) {
        $start = 1;
    }

    $end = $start + LEN_PAGE - 1;
    if($end > $totalPage) {
        $end = $totalPage;
    }

    $prevNo = $start - 1;
    $nextNo = $end + 1;
    $prev = $prevNo >= 1;
    $next = $nextNo <= $totalPage;

    $data = array_slice($data, ($page - 1) * LEN_ARTICLE, LEN_ARTICLE);

    return (object)compact("data", "page", "start", "end", "prevNo", "nextNo", "prev", "next");
}

function filter_realfile(Array $files, String $dirname) : Array
{   
    $validFiles = [];
    foreach($files as $file){
        if(is_file($dirname.DS.$file)) $validFiles[] = $file;
    }

    return $validFiles;
}

function extname($filename){
    return substr($filename, strrpos($filename, "."));
}

function upload_base64($dirname, $data, $filebase = null){
    if($filebase == null) $filebase = time();

    $split = explode(";base64,", $data);
    $split2 = explode("/", $split[0]);
    $content = base64_decode($split[1]);
    $extname = "." . $split2[1];
    $filename = $filebase . $extname;
    file_put_contents($dirname.DS.$filename, $content);
    return $filename;
}