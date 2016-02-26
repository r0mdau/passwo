<?php
session_start();

require_once('../autoload.php');

if (!isset($_SESSION['dateCreationSession']) || Controller::sessionExpiree()) Ordonnanceur::redirigerVers('/');
?>
<!doctype html>
<html class="no-js" lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= _APP_NOM_ ?></title>
    <meta name="description" content="Gestionnaire de mots de passe">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="lib/google/icon.css" rel="stylesheet">
    <link rel="stylesheet" href="lib/materialize/css/materialize.min.css">
</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please
    <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
</p>
<![endif]-->
<ul id="nav-mobile" class="side-nav fixed" style="width: 240px;">
    <li class="bold"><h3><?= _APP_NOM_ ?></h3></li>
    <li>
        <div class="input-field">
            <input id="search" type="search">
            <label for="search"><i class="material-icons">search</i></label>
            <i class="material-icons">close</i>
        </div>
    </li>
    <li class="bold"><a href="/" class="waves-effect waves-teal red-text text-accent-4">Déconnexion</a></li>
</ul>
<div class="row">
    <div class="col s10 offset-s2">
        <?= $carte ?>
    </div>
</div>
<div class="row">
    <form class="col s10 offset-s2" method="post" action="/action">
        <div class="input-field col s4">
            <input id="libelle" type="text" name="libelle" class="validate">
            <label for="libelle">Libellé</label>
        </div>
        <div class="input-field col s4">
            <input id="motDePasse" type="password" name="motDePasse" class="validate">
            <label for="motDePasse">Mot de passe</label>
        </div>
        <?= Vue::genererBoutonAjouter() ?>
    </form>
</div>
<div class="row">
    <div class="col s10 offset-s2">
        <table id="tableau" class="bordered highlight">
            <thead>
            <tr>
                <th>Libelle</th>
                <th>Mot de passe</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach (Modele::recupererMotsDePassesDe($_SESSION['chiffree']['email']) as $ligne) {
                echo '<tr>';
                echo '<td>' . Chiffrement::dechiffrer($ligne['libelle']) . '</td>';
                echo '<td><input type="password" value="' . Chiffrement::dechiffrer($ligne['valeur']) . '" disabled/></td>';
                echo '
                <td>
                    <a class="waves-effect waves-light btn-floating blue visibility"><i class="material-icons right">visibility</i></a>
                    <a class="waves-effect waves-light btn-floating red accent-4" href="/action?delete=' . $ligne['id'] . '"><i class="material-icons right">delete</i></a>
                </td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="lib/jquery/jquery-2.1.4.min.js"></script>
<script src="lib/materialize/js/materialize.min.js"></script>
<script src="lib/jquery/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        var tableau = $('#tableau').DataTable({
            "paging":   false,
            "order": [[ 0, "asc" ]],
            "info":     false
        });

        $('#tableau_filter').hide();

        $('#search').keyup(function(){
            tableau.search(this.value).draw();
        });

        $('.visibility').click(function () {
            if ($(this).children().html() == 'visibility') {
                $(this).parent().prev().children().attr({'type': 'text'});
                $(this).children().html('visibility_off');
            } else {
                $(this).parent().prev().children().attr({'type': 'password'});
                $(this).children().html('visibility');
            }
        });

    });
</script>
</body>
</html>