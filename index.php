<?php
session_start();
$_SESSION = array();

require_once('autoload.php');

if (Controller::formulaireEstValide()) {
    Ordonnanceur::supprimerComptesInactifs();
    $donneesCryptees = array(
        'email' => Hash::whirlpool($_POST['email']),
        'password' => Hash::whirlpool($_POST['password']),
        'pin' => Hash::whirlpool($_POST['pin'])
    );

    if (Modele::utilisateurActifExiste($donneesCryptees)) {
        $_SESSION = array(
            'dateCreationSession' => new DateTime(),
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'pin' => $_POST['pin']
        );
        Ordonnanceur::redirigerVers('/administrer');
    } else {
        if (Ordonnanceur::creerCompte($donneesCryptees, $_POST['email'])) {
            $_POST = array();
        } else {

        }
    }
}

$bouton =   '<button class="btn waves-effect waves-light" type="submit" name="action">Connexion
                <i class="material-icons right">send</i>
            </button>';
require_once('formulaire.php');