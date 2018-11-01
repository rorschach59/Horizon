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
            $_SESSION['flash']['level'] = 'danger';
            $_SESSION['flash']['message'] = 'Le streamer existe déjà';
        } else {
            self::$result = self::$db->prepare("INSERT INTO streamers (pseudo, active) VALUES (?, ?)");
            self::$result->bindParam(1, $params['streamer_pseudo']);
            self::$result->bindParam(2, $params['streamer_active']);
            if(self::$result->execute()) {
                $_SESSION['flash']['level'] = 'success';
                $_SESSION['flash']['message'] = 'Le streamer a été créé';
            }
        }
        
    }

}