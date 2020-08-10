<?php
namespace Core;

class Router {
    static $pages = [];
    static function __callStatic($name, $args){
        if(strtolower($_SERVER['REQUEST_METHOD']) === $name){
            self::$pages[] = $args;
        }
    }

    static function connect(){
        $currentURL = explode("?", $_SERVER['REQUEST_URI'])[0];
        foreach(self::$pages as $page){
            if($page[0] === $currentURL) {
                if(isset($page[2]) && $page[2] === "user" && !isLogin()) back("로그인 후 이용하실 수 있습니다.");
                $action = explode("@", $page[1]);
                $conName = "Controller\\{$action[0]}";
                $con = new $conName();
                $con->{$action[1]}();
                exit;
            }
        }
        http_response_code(404);
    }
}