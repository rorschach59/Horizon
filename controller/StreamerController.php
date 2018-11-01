<?php

class StreamerController extends DefaultController
{

    public static function home()
    {

        // Si le formulaire pour ajouter un streamer est envoyé
        if(isset($_POST['streamer_pseudo']) && !empty(trim($_POST['streamer_pseudo']))) {
            self::addStreamer();
        } elseif(isset($_POST['streamer_pseudo']) && empty(trim($_POST['streamer_pseudo']))) {
            echo ErrorController::flashMessage('danger', 'Le pseudo du streamer ne peut pas être vide');
        }
    
        // Si le formulaire pour désactiver ou update un streamer est envoyé
        if(isset($_POST['delete']) || isset($_POST['update'])) {
            self::updateStreamer();
        }

        $streamers = DatabaseModel::select(
            'SELECT id_streamer, pseudo, active, date_creation, 
            IFNULL(date_update, "-") as date_update, IFNULL(date_delete, "-") as date_delete
            FROM streamers');

        // On affiche la vue
        DefaultController::show('BO/addStreamer', compact('streamers'));
    }

    private function addStreamer()
    {
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

    private function updateStreamer()
    {
        
        // Si on souhaite désactiver le streamer
        if (isset($_POST['delete'])) {
            $params['id_streamer'] = $_POST['id_streamer'];
            $params['active'] = $_POST['delete'];

            // On update le statut du streamer
            StreamerModel::deleteStreamer($params);
        }

        // Si on souhaite modifier le pseudo du streamer
        if (isset($_POST['update'])) {
            if (!empty($_POST['pseudo'])) {
                $params['id_streamer'] = $_POST['id_streamer'];
                $params['pseudo'] = $_POST['pseudo'];

                // On update le statut du streamer
                StreamerModel::updateStreamer($params);
            } else {
                echo ErrorController::flashMessage('danger', 'Le pseudo du streamer ne peut pas être vide');
            }
        }
    }
}