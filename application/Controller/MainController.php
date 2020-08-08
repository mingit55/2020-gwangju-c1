<?php
namespace Controller;

use Core\DB;

class MainController {
    /**
     * 페이지 목록
     */
    function homePage(){
        view("home");
    }

    function noticePage(){
        view("notice");
    }

    function exchangePage(){
        view("exchange-guide");
    }

    function majorFestivalPage(){
        view("major-festival");
    }

    
}