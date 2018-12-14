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

        $today = strtotime(date('Y-m-d'));
        $params['beginWeek'] = date('Y-m-d', strtotime('last Monday', $today));
        $params['finishWeek'] = date('Y-m-d', strtotime('next Monday', $today));
        $params['id_streamer'] = 1;

        $data = StreamerModel::getProg($params);
        $sidebar = new SidebarController();

        if(isset($_GET['sub']) && $_GET['sub'] === 'true') {
            $successSub = UserController::successSub();
            DefaultController::show('home', compact('successSub', 'data', 'sidebar'));
        } else {
            DefaultController::show('home', compact('data', 'sidebar'));
        }
    }
}