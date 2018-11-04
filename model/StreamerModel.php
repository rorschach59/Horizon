<?php

class StreamerModel extends DatabaseModel
{

    public static function insertStreamer($params)
    {
        
        self::$db = DatabaseModel::getDatabase();

        $streamer_exists = DatabaseModel::select(
            'SELECT id_streamer 
            FROM streamers 
            WHERE pseudo = "'.$params['streamer_pseudo'].'"'
        );
        
        if(current($streamer_exists)['id_streamer'] > 0) {
            echo ErrorController::flashMessage('danger', 'Le streamer existe déjà');
        } else {
            self::$result = self::$db->prepare("INSERT INTO streamers (pseudo, active) VALUES (?, ?)");
            self::$result->bindParam(1, $params['streamer_pseudo']);
            self::$result->bindParam(2, $params['streamer_active']);
            if(self::$result->execute()) {
                echo ErrorController::flashMessage('success', 'Le streamer a été créé');
            } else {

                echo ErrorController::flashMessage('danger', 'Une erreur s\'est produite');

                ErrorController::errorLog(self::$result->queryString);
                ErrorController::errorLog(self::$result->errorInfo()[2]);
                ErrorController::errorLog(get_called_class().'php, ligne '.__LINE__);
            }
        }
        
    }

    public static function deleteStreamer($params)
    {
        self::$db = DatabaseModel::getDatabase();

        $streamer = DatabaseModel::select(
            'SELECT id_streamer 
            FROM streamers 
            WHERE id_streamer = "'.$params['id_streamer'].'"'
        );
        
        if(current($streamer)['id_streamer'] > 0) {
            self::$result = self::$db->prepare("UPDATE streamers SET active = :active WHERE id_streamer = :id_streamer");
            self::$result->bindParam(':active', $params['active']);
            self::$result->bindParam(':id_streamer', $params['id_streamer']);
            if(self::$result->execute()) {
                
                self::$result = self::$db->prepare('UPDATE streamers SET date_delete = \''.date('Y-m-d H:i:s').'\' WHERE id_streamer = :id_streamer');
                self::$result->bindParam(':id_streamer', $params['id_streamer']);
                self::$result->execute();
                                
                $statut = $params['active'] == '0' ? 'désactivé' : 'activé';
                echo ErrorController::flashMessage('primary', 'Le streamer est '.$statut);
            } else {

                echo ErrorController::flashMessage('danger', 'Une erreur s\'est produite');

                ErrorController::errorLog(self::$result->queryString);
                ErrorController::errorLog(self::$result->errorInfo()[2]);
                ErrorController::errorLog(get_called_class().'.php, ligne '.__LINE__);
            }
        } else {
            echo ErrorController::flashMessage('danger', 'Le streamer demandé n\'existe pas');
        }
        
    }

    public static function updateStreamer($params)
    {
        
        self::$db = DatabaseModel::getDatabase();

        $streamer = DatabaseModel::select(
            'SELECT id_streamer, pseudo 
            FROM streamers 
            WHERE id_streamer = "'.$params['id_streamer'].'"'
        );
        
        if(current($streamer)['id_streamer'] > 0) {

            $old_pseudo = current($streamer)['pseudo'];
            $new_pseudo = $params['pseudo'];

            if($old_pseudo !== $new_pseudo) {
                self::$result = self::$db->prepare("UPDATE streamers SET pseudo = :pseudo WHERE id_streamer = :id_streamer");
                self::$result->bindParam(':pseudo', $params['pseudo']);
                self::$result->bindParam(':id_streamer', $params['id_streamer']);
                if(self::$result->execute()) {
                    
                    $new_pseudo = $params['pseudo'];
    
                    self::$result = self::$db->prepare('UPDAT streamers SET date_update = \''.date('Y-m-d H:i:s').'\' WHERE id_streamer = :id_streamer');
                    self::$result->bindParam(':id_streamer', $params['id_streamer']);
                    self::$result->execute();

                    echo ErrorController::flashMessage('success', 'Le streamer '.$old_pseudo.' a été renommé en '.$new_pseudo);
                } else {
    
                    echo ErrorController::flashMessage('danger', 'Une erreur s\'est produite');
    
                    ErrorController::errorLog(self::$result->queryString);
                    ErrorController::errorLog(self::$result->errorInfo()[2]);
                    ErrorController::errorLog(get_called_class().'.php, ligne '.__LINE__);
    
                }
            } else {
                echo ErrorController::flashMessage('primary', 'Le pseudo est le même'); 
            } 
        } else {
            echo ErrorController::flashMessage('danger', 'Le streamer demandé n\'existe pas');
        }
        
    }

}