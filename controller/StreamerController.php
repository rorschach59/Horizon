<?php

class StreamerController extends DefaultController
{

    public static function home()
    {
        // Si le formulaire est envoyé
        if(isset($_POST['streamer_pseudo']) && !empty(trim($_POST['streamer_pseudo']))) {

            // Tableau pour l'insert
            $params['streamer_pseudo'] = $_POST['streamer_pseudo'];
            if (isset($_POST['streamer_active'])) {
                if ($_POST['streamer_active'] === "on") {
                    $params['streamer_active'] = 1;
                }
            } else {
                $params['streamer_active'] = 0;
            }
            
            // On ajoute le streamer
            StreamerModel::insertStreamer($params);
        }

        $streamers = DatabaseModel::select(
            'SELECT id_streamer, pseudo, active, date_creation, 
            IFNULL(date_update, "-") as date_update, IFNULL(date_delete, "-") as date_delete
            FROM streamers');

        // On affiche la vue
        DefaultController::show('BO/addStreamer', compact('streamers'));
    }

}