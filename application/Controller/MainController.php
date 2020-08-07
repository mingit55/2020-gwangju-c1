<?php
namespace Controller;

class MainController {
    function homePage(){
        view("home");
    }

    function majorFestivalPage(){
        view("major-festival");
    }
}