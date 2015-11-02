<?php
session_start();

require_once('../autoload.php');
$carte = Vue::genererCarte();
$_SESSION = array();

if (Controller::formulaireEstValide($_POST)) {
    Ordonnanceur::supprimerComptesInactifs();
    $donneesChiffrees = Ordonnanceur::genererDonneesHachees($_POST);
    if (Modele::utilisateurActifExiste($donneesChiffrees)) {
        Ordonnanceur::connexionReussie($_POST, $donneesChiffrees);
    } else if (Ordonnanceur::creerCompte($donneesChiffrees, $_POST['email'])) {
        Ordonnanceur::finDeTransaction('Votre compte a été créé.<br>Nous vous avons envoyé un email, veuillez suivre les instructions de celui-ci.', 'Success');
    } else {
        Ordonnanceur::finDeTransaction('
            Causes possibles :
            <ul>
                <li>Un problème est survenu lors de la connexion ou la création de votre compte.</li>
                <li>Vous n\'avez pas activé votre compte, vérifiez vos emails.</li>
                <li>Vous avez peut-être déjà créé un compte mais il n\'est pas actif car votre token est périmé.</li>
            </ul>
        ');
    }
}

$bouton = Vue::genererBoutonIndex();
require_once('formulaire.php');