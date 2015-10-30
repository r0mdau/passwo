<?php
session_start();
$_SESSION = array();

require_once('autoload.php');

if(
    isset($_POST['email']) && !empty($_POST['email']) &&
    isset($_POST['password']) && !empty($_POST['password']) &&
    isset($_POST['pin']) && !empty($_POST['pin'])
){
    $crypted = array(
        'email' => Hash::whirlpool($_POST['email']),
        'password' => Hash::whirlpool($_POST['password']),
        'pin' => Hash::whirlpool($_POST['pin'])
    );

    if(Data::userExist($crypted)){
        $_SESSION = array(
            'dateLogin' => new DateTime(),
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'pin' => $_POST['pin'],
            'hash' => $crypted
        );
        header('Location: /yo.php');
        exit;
    }else{
        $userCreated = Data::createUser($crypted);
    }
}
?>
<!doctype html>
<html class="no-js" lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Passwho</title>
    <meta name="description" content="Web Password Manager">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/css/materialize.min.css">
</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please
    <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
</p>
<![endif]-->

<div class="container">
    <div class="row">
        <form class="col s6 offset-s3" method="post">
            <h3>P/\5$W||0</h3>
            <div class="row">
                <div class="input-field col s12">
                    <input id="email" type="email" name="email" class="validate">
                    <label for="email">Email</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" type="password" name="password" class="validate">
                    <label for="password">Password</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="pin" type="password" name="pin" class="validate" placeholder="4 digits">
                    <label for="pin">PIN</label>
                </div>
            </div>
            <div class="row">
                <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                    <i class="material-icons right">send</i>
                </button>
                <?php
                if(isset($userCreated) && $userCreated) echo "<p>Compte créé, vérifiez vos mails</p>"
                ?>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/js/materialize.min.js"></script>
</body>
</html>