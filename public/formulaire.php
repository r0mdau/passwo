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

<div class="container">
    <?= $carte ?>
    <div class="row">
        <form class="col s6 offset-s3" method="post">
            <h3><?= _APP_NOM_ ?></h3>

            <div class="row">
                <div class="input-field col s12">
                    <input id="email" type="email" name="email"
                           class="validate" <?= isset($_POST['email']) && !empty($_POST['email']) ? ' value="' . $_POST['email'] . '" ' : '' ?>>
                    <label for="email">Adresse Email</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="motDePasse" type="password" name="motDePasse" class="validate"
                           placeholder="<?= _MOTDEPASSE_TAILLE_REQUISE_ ?> caractères mininmum">
                    <label for="motDePasse">Mot de passe</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="pin" type="password" name="pin" class="validate" placeholder="4 chiffres">
                    <label for="pin">PIN</label>
                </div>
            </div>
            <div class="row">
                <?= $bouton ?>
            </div>
        </form>
    </div>
</div>

<script src="lib/jquery/jquery-2.1.4.min.js"></script>
<script src="lib/materialize/js/materialize.min.js"></script>
</body>
</html>