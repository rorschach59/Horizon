<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="/public/css/main.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/public/css/lib/fullcalendar.min.css" />
    <link rel="stylesheet" type="text/css" media="print" href="/public/css/lib/fullcalendar.print.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/public/css/lib/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/public/css/lib/bootstrap-grid.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/public/css/lib/bootstrap-reboot.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/public/css/lib/bootstrap-sketchy.css" />
    <!-- <link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/sketchy/bootstrap.min.css"/> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatica+SC" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster+Two" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Anton' rel='stylesheet'>
    <script src="/public/js/lib/jquery.min.js"></script>

    <title>Horizon</title>
</head>
<body>

    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/"><img width="150px" src="/public/img/logo_transparent_background.png" alt="Horizon"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav justify-content-end list-unstyled navbar-text">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mon compte
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) { ?>

                            <a class="dropdown-item" href="#">Gestion du compte</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/deconnexion/">Se déconnecter</a>

                        <?php } else { ?>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target=".bd-example-modal-lg">Connexion</a>
                            <a class="dropdown-item" href="/inscription/">Inscription</a>
                            <!-- <a class="dropdown-item" href="#">Gestion du compte</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Se déconnecter</a> -->

                        <?php } ?>
                        </div>
                    </li>
                </ul>
            </div>
            
        </nav>

        <div id="modalLogin" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Connexion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="/connexion/">
                            <input type="hidden" name="login">
                            <div class="form-group">
                                <label for="user_login">Pseudo de connexion</label>
                                <input type="text" class="form-control" id="user_login" name="user_login" placeholder="Pseudo de connexion" data-validation="length" data-validation-length="min3">
                            </div>
                            <div class="form-group">
                                <label for="user_pwd">Password</label>
                                <input type="password" class="form-control" id="user_pwd" name="user_pwd" placeholder="Mot de passe" data-validation="length" data-validation-length="min3">
                            </div>
                            <p><a href="/inscription/">Pas encore de compte ?</a></p>
                            <button type="submit" class="btn btn-primary">Se connecter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </header>

    <script>
    
        $(document).ready(function() {

            $.validate({
                lang: 'fr'
            });

        });                  
        
    </script>