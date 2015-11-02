<?php
session_start();

require_once('autoload.php');

if (!isset($_SESSION['dateCreationSession']) || Controller::sessionExpiree()) Ordonnanceur::redirigerVers('/');
?>
<!doctype html>
<html class="no-js" lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= _APP_NOM_ ?></title>
    <meta name="description" content="Web Password Manager">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="lib/materialize/css/materialize.min.css">
</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please
    <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
</p>
<![endif]-->
<ul id="nav-mobile" class="side-nav fixed" style="width: 240px;">
    <li class="bold"><h3><?=_APP_NOM_?></h3></li>
    <li class="bold"><a href="/" class="waves-effect waves-teal red-text text-accent-4">Déconnexion</a></li>
</ul>
<div class="">
    <div class="row">
        <?= $carte ?>
        <div class="col s10 offset-s2">
            <table class="bordered highlight">
                <thead>
                <tr>
                    <th data-field="id">Libelle</th>
                    <th data-field="name">Mot de passe</th>
                    <th data-field="price">Actions</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>Alvin</td>
                    <td><input type="password" value="Eclair" disabled/></td>
                    <td>
                        <a class="waves-effect waves-light btn-floating blue visibility"><i class="material-icons right">visibility</i></a>
                        <a class="waves-effect waves-light btn-floating red accent-4"><i class="material-icons right">delete</i></a>
                    </td>
                </tr>
                <tr>
                    <td>Alan</td>
                    <td><input type="password" value="Jellybean" disabled/></td>
                    <td>
                        <a class="waves-effect waves-light btn-floating blue visibility"><i class="material-icons right">visibility</i></a>
                        <a class="waves-effect waves-light btn-floating red accent-4"><i class="material-icons right">delete</i></a>
                    </td>
                </tr>
                <tr>
                    <td>Jonathan</td>
                    <td><input type="password" value="Lollipop" disabled/></td>
                    <td>
                        <a class="waves-effect waves-light btn-floating blue visibility"><i class="material-icons right">visibility</i></a>
                        <a class="waves-effect waves-light btn-floating red accent-4"><i class="material-icons right">delete</i></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="lib/jquery/jquery-2.1.4.min.js"></script>
<script src="lib/materialize/js/materialize.min.js"></script>
<script>
    $(document).ready(function(){
        $('.visibility').click(function(){
            if($(this).children().html() == 'visibility') $(this).children().html('visibility_off');
              else $(this).children().html('visibility');
        });
    });
</script>
</body>
</html>