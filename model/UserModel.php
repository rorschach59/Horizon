<?php

class UserModel extends DatabaseModel
{
    public static function insertUser($params)
    {
        self::$db = DatabaseModel::getDatabase();

        $user_exists = DatabaseModel::select(
            'SELECT id_user, user_email, login 
            FROM users 
            WHERE user_email = "'.$params['sub_user_email'].'"
            OR login = "'.$params['sub_user_login'].'"'
        );
        
        if(current($user_exists)['id_user'] > 0) {
            $email_exists = current($user_exists)['user_email'] == $params['sub_user_email'] ? 1 : 0;
            //$login_exists = current($user_exists)['login'] == $params['sub_user_login'] ? 1 : 0;
            $erreur = $email_exists === 1 ? 'L\'adresse e-mail' : 'Le login';
            echo ErrorController::flashMessage('danger',  $erreur.' existe déjà');
        } else {
            try {
                $role = 'admin';
                self::$result = self::$db->prepare("INSERT INTO users (user_email, login, password, role) VALUES (?, ?, ?, ?)");
                self::$result->bindParam(1, $params['sub_user_email']);
                self::$result->bindParam(2, $params['sub_user_login']);
                self::$result->bindParam(3, $params['sub_user_pwd']);
                self::$result->bindParam(4, $role);
                if (self::$result->execute()) {
                    $userInfos['user_id'] = self::$db->lastInsertId(); 
                    $userInfos['user_login'] = $params['sub_user_login']; 
                    $userInfos['user_email'] = $params['sub_user_email']; 
                    $userInfos['user_role'] = $role;
                    UserController::instanceSession($userInfos);
                }
                else {
                    echo ErrorController::flashMessage('danger', 'Une erreur s\'est produite');
    
                    ErrorController::errorLog(self::$result->queryString);
                    ErrorController::errorLog(self::$result->errorInfo()[2]);
                    ErrorController::errorLog(get_called_class().'.php ligne '.__LINE__);
                }
            } catch(Exception $e) {
                dump('erreur');
            }    
        }
    }

    public static function authorizedConnection($params)
    {
        $params['user_pwd'] = $_POST['user_pwd'];
        $user_exists = DatabaseModel::select(
            'SELECT id_user, user_email, login, password, role
            FROM users
            WHERE login = "'.$params['user_login'].'"'
        );

        if(current($user_exists)['id_user'] > 0) {
            if (password_verify($params['user_pwd'], current($user_exists)['password'])) {
                $userInfos['user_id'] = current($user_exists)['id_user']; 
                $userInfos['user_login'] = current($user_exists)['user_email']; 
                $userInfos['user_email'] = current($user_exists)['login']; 
                $userInfos['user_role'] = current($user_exists)['role'];
                $authorizedConnection['success'] = true;
                $authorizedConnection['userInfos'] = $userInfos;
                return $authorizedConnection;
            } else {
                header('Location: http://192.168.1.17:1801/');
                echo ErrorController::flashMessage('danger', 'Votre mot de passe n\'est pas correct');
                $authorizedConnection['success'] = false;
            }
        } else {
            header('Location: http://192.168.1.17:1801/');
            echo ErrorController::flashMessage('danger', 'Votre pseudo n\'existe pas');
            $authorizedConnection['success'] = false;
        }
        return $authorizedConnection;
    }

}