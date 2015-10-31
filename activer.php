<?php
session_start();

require_once('autoload.php');

function finDeTransaction()
{
    Ordonnanceur::redirigerVers('/');
    $_SESSION = array();
}

if (!Controller::tokenEstBienFormate()) {
    finDeTransaction();
} else {
    $_SESSION['token'] = $_GET['token'];
}

if (Controller::tokenEstBienFormate() && Controller::formulaireEstValide()) {
    if(Controller::tokenVeritable($_SESSION['token'])){
        $donneesCryptees = array(
            'email' => Hash::whirlpool($_POST['email']),
            'password' => Hash::whirlpool($_POST['password']),
            'pin' => Hash::whirlpool($_POST['pin'])
        );
        if(Modele::activerUtilisateur($donneesCryptees)){
            $_SESSION = array(
                'dateCreationSession' => new DateTime(),
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'pin' => $_POST['pin']
            );
            Ordonnanceur::redirigerVers('/administrer');
        } else {
            finDeTransaction();
        }
    } else {
        finDeTransaction();
    }
}

$bouton = '<button class="btn waves-effect waves-light green" type="submit" name="action">Activer
                <i class="material-icons right">send</i>
            </button>';
require_once('formulaire.php');