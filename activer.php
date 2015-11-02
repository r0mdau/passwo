<?php
session_start();
$_SESSION = array();

require_once('autoload.php');

if (Controller::tokenEstBienFormate($_GET['token']) && Controller::formulaireEstValide($_POST)) {
    if (Controller::tokenVeritable($_POST['email'], $_GET['token'])) {
        $donneesCryptees = Ordonnanceur::genererDonneesHachees($_POST);
        if (Modele::activerUtilisateur($donneesCryptees)) {
            Token::supprimer($_POST['email']);
            Ordonnanceur::connexionReussie($_POST);
        } else {
            Ordonnanceur::finDeTransaction('
                Causes possibles :
                <ul>
                    <li>Les informations saisies dans le formulaire ne sont pas valides.</li>
                    <li>Mauvais token associé à cet utilisateur.</li>
                </ul>
            ');
        }
    } else {
        Ordonnanceur::finDeTransaction('
            Causes possibles :
            <ul>
                <li>Les informations saisies dans le formulaire ne sont pas valides</li>
                <li>Mauvais token associé à cet utilisateur.</li>
                <li>Le token a expiré.</li>
            </ul>
        ');
    }
}

$bouton = Vue::genererBoutonActiver();
require_once('formulaire.php');