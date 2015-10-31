<?php
session_start();
$_SESSION = array();

require_once('autoload.php');

if (!Controller::tokenEstBienFormate()) Ordonnanceur::finDeTransaction('Token non valide.');

if (Controller::tokenEstBienFormate() && Controller::formulaireEstValide()) {
    if (Controller::tokenVeritable($_POST['email'], $_GET['token'])) {
        $donneesCryptees = array(
            'email' => Hash::whirlpool($_POST['email']),
            'password' => Hash::whirlpool($_POST['password']),
            'pin' => Hash::whirlpool($_POST['pin'])
        );
        if (Modele::activerUtilisateur($donneesCryptees)) {
            Controller::supprimerToken($_POST['email']);
            $_SESSION = array(
                'dateCreationSession' => new DateTime(),
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'pin' => $_POST['pin']
            );
            Ordonnanceur::redirigerVers('/administrer');
        } else {
            Ordonnanceur::finDeTransaction('Les informations saisies dans le formulaire ne sont pas valides ou bien mauvais token associé à cet utilisateur.');
        }
    } else {
        Ordonnanceur::finDeTransaction('Les informations saisies dans le formulaire ne sont pas valides ou bien mauvais token associé à cet utilisateur.');
    }
}

$bouton = '<button class="btn waves-effect waves-light green" type="submit" name="action">Activer
                <i class="material-icons right">send</i>
            </button>';
require_once('formulaire.php');