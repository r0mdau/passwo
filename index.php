<?php
session_start();

require_once('autoload.php');
$carte = Ordonnanceur::genererCarte();
$_SESSION = array();

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
    }

    if (Ordonnanceur::creerCompte($donneesCryptees, $_POST['email'])) {
        $_POST = array();
        Ordonnanceur::finDeTransaction('Votre compte a été créé.<br>Nous vous avons envoyé un email, veuillez suivre les instructions de celui-ci.', 'Success');
    } else {
        Ordonnanceur::finDeTransaction('
            Un problème est survenu lors de la création de votre compte. <br>
            Vous avez peut-être déjà tenté de créer un compte mais il n\'est pas actif car votre token est invalide.<br>
            Dans le doute, patientez 15 minutes avant une nouvelle tentative.
        ');
    }
}

$bouton = '<button class="btn waves-effect waves-light" type="submit" name="action">Connexion
                <i class="material-icons right">send</i>
            </button>';
require_once('formulaire.php');