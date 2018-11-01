<?php 

$routes = 
    [
        ['GET|POST', '/horizon/', 'HomeController::home', 'home'],
        ['GET|POST', '/horizon/addStreamer/', 'StreamerController::home', 'homeStreamer'],
    ];