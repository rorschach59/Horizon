<?php

class UserController extends DefaultController
{
    public function subscribe()
    {

        if(isset($_POST['new_sub'])) {
            self::addUser();
        }

        DefaultController::show('user/subscribe');
    }

    private static function addUser()
    {
        if(!empty(trim($_POST['sub_user_email'])) && !empty(trim($_POST['sub_user_login'])) && !empty(trim($_POST['sub_user_pwd']))) {
            
            $params['sub_user_email'] = trim($_POST['sub_user_email']);
            $params['sub_user_login'] = trim($_POST['sub_user_login']);
            $params['sub_user_pwd'] = password_hash(trim($_POST['sub_user_pwd']),PASSWORD_BCRYPT);

            UserModel::insertUSer($params);
        } else {
            echo ErrorController::flashMessage('danger', 'Un des champs est vide');
        }
        
    }

    public static function successSub()
    {
        return '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Merci de t\'être inscris, tu peux désormais profiter de toutes les fonctionnalités du site, have fun :) 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }

    public static function loginUser()
    {
        if(!empty(trim($_POST['user_login'])) && !empty(trim($_POST['user_pwd']))) {
            $params['user_login'] = $_POST['user_login'];
            $params['user_pwd'] = $_POST['user_pwd'];
            $authorizedConnection = UserModel::authorizedConnection($params);
            
            if($authorizedConnection['success'] === true) {
                self::instanceSession($authorizedConnection['userInfos']);
            }
        } else {
            echo ErrorController::flashMessage('danger', 'Veuillez remplir le formulaire');
        }

    }

    public static function instanceSession($userInfos)
    {
        $_SESSION['user_id'][$userInfos['user_id']] = $userInfos['user_id'];
        $_SESSION['user_login'][$userInfos['user_id']] = $userInfos['user_login'];
        $_SESSION['user_email'][$userInfos['user_id']] = $userInfos['user_email'];
        $_SESSION['user_role'][$userInfos['user_id']] = $userInfos['user_role'];
        header('Location: http://192.168.1.17:1801/');
    }

    public static function logout()
    {
        session_destroy();
        header('Location: http://192.168.1.17:1801/');
    }
}