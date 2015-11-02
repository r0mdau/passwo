<?php
session_start();

require_once('autoload.php');
$carte = Vue::genererCarte();
$_SESSION = array();

if (Controller::formulaireEstValide($_POST)) {
    Ordonnanceur::supprimerComptesInactifs();
    $donneesCryptees = Ordonnanceur::genererDonneesHachees($_POST);
    if (Modele::utilisateurActifExiste($donneesCryptees)) {
        Ordonnanceur::connexionReussie($_POST);
    } else if (Ordonnanceur::creerCompte($donneesCryptees, $_POST['email'])) {
        $_POST = array();
        Ordonnanceur::finDeTransaction('Votre compte a été créé.<br>Nous vous avons envoyé un email, veuillez suivre les instructions de celui-ci.', 'Success');
    } else {
        Ordonnanceur::finDeTransaction('
            Un problème est survenu lors de la connexion/création de votre compte. <br>
            Votre compte existe et est actif mais les informations saises dans le formulaire sont incorrectes.<br>
            Vous avez peut-être déjà tenté de créer un compte mais il n\'est pas actif car votre token est invalide.<br>
            Dans le doute, patientez 15 minutes avant une nouvelle tentative.
        ');
    }
}

$bouton = Vue::genererBoutonIndex();
require_once('formulaire.php');