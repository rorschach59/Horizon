<?php

class HomeController extends DefaultController
{

    public static function home()
    {

        // if(isset($_POST) && isset($_POST['login'])) {
        //     if(!empty(trim($_POST['user_login'])) && !empty(trim($_POST['user_pwd']))) {
        //         UserController::loginUser();
        //     }
        // }

        if(isset($_GET['sub']) && $_GET['sub'] === 'true') {
            $successSub = UserController::successSub();
            DefaultController::show('home', compact('successSub'));
        } else {
            DefaultController::show('home');
        }
    }
}