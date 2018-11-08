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

    public static function insertPlanningStreamer($params)
    {
        
        self::$db = DatabaseModel::getDatabase();

        $streamer_exists = DatabaseModel::select(
            'SELECT id_streamer 
            FROM streamers
            WHERE id_streamer = "'.$params['id_streamer'].'"'
        );
        
        if(current($streamer_exists)['id_streamer'] > 0) {

            $event_exists = DatabaseModel::select(
                'SELECT id_prog 
                FROM streamers_prog
                WHERE uid = "'.$params['uid'].'"
                AND event_id = "'.$params['event_id'].'"
                AND title = "'.$params['title'].'"
                AND id_streamer = "'.$params['id_streamer'].'"'
            );

            if (current($event_exists)['id_prog'] > 0) {

                $params['id_prog'] = current($event_exists)['id_prog'];
                self::updatePlanningStreamer($params);
                
            } else {
                self::$result = self::$db->prepare("
                    INSERT INTO streamers_prog (id_streamer, uid, event_id, title, streamBeginning, streamFinishing, active) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");

                self::$result->bindParam(1, $params['id_streamer']);
                self::$result->bindParam(2, $params['uid']);
                self::$result->bindParam(3, $params['event_id']);
                self::$result->bindParam(4, $params['title']);
                self::$result->bindParam(5, $params['streamBeginning']);
                self::$result->bindParam(6, $params['streamFinishing']);
                self::$result->bindParam(7, $params['active']);            

                if(self::$result->execute()) {
                    error_log('insert ok');
                    //echo ErrorController::flashMessage('success', 'Le streamer a été créé');
                } else {
                    error_log('insert pas ok');
                    // echo ErrorController::flashMessage('danger', 'Une erreur s\'est produite');

                    ErrorController::errorLog(self::$result->queryString);
                    ErrorController::errorLog(self::$result->errorInfo()[2]);
                    ErrorController::errorLog(get_called_class().'php, ligne '.__LINE__);

                    return false;
                }
            }
        } else {
            error_log('Le streamer n\'existe pas');
            // echo ErrorController::flashMessage('danger', 'Le streamer n\'existe pas');
        }
        
    }

    private static function updatePlanningStreamer($params)
    {
        self::$db = DatabaseModel::getDatabase();

        self::$result = self::$db->prepare("
            UPDATE streamers_prog 
            SET streamBeginning = :streamBeginning, streamFinishing = :streamFinishing
            WHERE id_prog = :id_prog");

        self::$result->bindParam(':streamBeginning', $params['streamBeginning']);
        self::$result->bindParam(':streamFinishing', $params['streamFinishing']);
        self::$result->bindParam(':id_prog', $params['id_prog']);

        if (self::$result->execute()) {
            self::$result = self::$db->prepare('UPDATE streamers_prog SET date_update = \''.date('Y-m-d H:i:s').'\' WHERE id_prog = :id_prog');
            self::$result->bindParam(':id_prog', $params['id_prog']);
            if (self::$result->execute()) {
                error_log('update ok');
            } else {
                ErrorController::errorLog(self::$result->queryString);
                ErrorController::errorLog(self::$result->errorInfo()[2]);
                ErrorController::errorLog(get_called_class().'php, ligne '.__LINE__);
            }
        } else {
            error_log('update pas ok');
        }
    }

    public static function deletePlanningStreamer($params)
    {
        self::$db = DatabaseModel::getDatabase();

        $event_exists = DatabaseModel::select(
            'SELECT id_prog 
            FROM streamers_prog
            WHERE uid = "'.$params['uid'].'"
            AND event_id = "'.$params['event_id'].'"
            AND title = "'.$params['title'].'"
            AND id_streamer = "'.$params['id_streamer'].'"'
        );

        error_log(current($event_exists)['id_prog']);
        
        if (current($event_exists)['id_prog'] > 0) {
            self::$result = self::$db->prepare("UPDATE streamers_prog SET active = :active WHERE id_prog = :id_prog");
            self::$result->bindParam(':active', $params['active']);
            self::$result->bindParam(':id_prog', current($event_exists)['id_prog']);
            if (self::$result->execute()) {
                self::$result = self::$db->prepare('UPDATE streamers_prog SET date_delete = \''.date('Y-m-d H:i:s').'\' WHERE id_prog = :id_prog');
                self::$result->bindParam(':id_prog', current($event_exists)['id_prog']);
                self::$result->execute();
                error_log('delete ok');
            } else {
                ErrorController::errorLog(self::$result->queryString);
                ErrorController::errorLog(self::$result->errorInfo()[2]);
                ErrorController::errorLog(get_called_class().'php, ligne '.__LINE__);
                error_log('delete pas ok');
            }
        }
    }

    public static function insertGame($params)
    {
        self::$db = DatabaseModel::getDatabase();

        $game_exists = DatabaseModel::select(
            'SELECT id_game 
            FROM games 
            WHERE title = "'.$params['game_title'].'"'
        );
        
        if(current($game_exists)['id_game'] > 0) {
            echo ErrorController::flashMessage('danger', 'Le jeu existe déjà');
        } else {
            self::$result = self::$db->prepare("INSERT INTO games (title) VALUES (?)");
            self::$result->bindParam(1, $params['game_title']);
            if(self::$result->execute()) {
                echo ErrorController::flashMessage('success', 'Le jeu a été ajouté');
            } else {
                echo ErrorController::flashMessage('danger', 'Une erreur s\'est produite');

                ErrorController::errorLog(self::$result->queryString);
                ErrorController::errorLog(self::$result->errorInfo()[2]);
                ErrorController::errorLog(get_called_class().'php, ligne '.__LINE__);
            }            
        }
    }
    
}