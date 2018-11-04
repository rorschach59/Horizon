<?php 

$routes = 
    [
        ['GET|POST', '/', 'HomeController::home', 'home'],
        ['GET|POST', '/ajoutStreamer/', 'StreamerController::home', 'homeStreamer'],
        ['GET|POST', '/inscription/', 'UserController::subscribe', 'userSubscribe'],
        ['GET|POST', '/connexion/', 'UserController::loginUser', 'userLogin'],
        ['GET|POST', '/deconnexion/', 'UserController::logout', 'userLogout'],
    ];