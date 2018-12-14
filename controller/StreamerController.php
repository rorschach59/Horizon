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
    
    public static function addPlanning()
    {

        if(isset($_POST['addProg']) && !empty($_POST['addProg'])) {            
            $params['id_streamer'] = 1; //$_SESSION['userId'];
            $params['uid'] = $_POST['uid'];
            $params['event_id'] = $_POST['event_id'];
            $params['title'] = $_POST['title'];
            $params['streamBeginning'] = date('Y-m-d H:i:s', strtotime($_POST['start'] . '-1 hour'));
            $params['streamFinishing'] = date('Y-m-d H:i:s', strtotime($_POST['end'] . '-1 hour'));
            $params['active'] = 1;
            
            if(!StreamerModel::insertPlanningStreamer($params)){
                return false;
            }
        }

        if(isset($_POST['addGame']) && !empty($_POST['addGame'])) {
            $params['game_title'] = $_POST['game_title'];
            StreamerModel::insertGame($params);
        }

        if(isset($_POST['deleteProg']) && !empty($_POST['deleteProg'])) {
            $params['id_streamer'] = 1; //$_SESSION['userId'];
            $params['uid'] = $_POST['uid'];
            $params['event_id'] = $_POST['event_id'];
            $params['title'] = $_POST['title'];
            $params['active'] = 0;

            StreamerModel::deletePlanningStreamer($params);
        }

        $games = DatabaseModel::select('SELECT title FROM games');
        
        DefaultController::show('BO/addPlanning', compact('games'));
    }

}