<?php
session_start();
$_SESSION = array();

require_once('autoload.php');

if (!Controller::tokenEstBienFormate()) Ordonnanceur::finDeTransaction('Token non valide.');

if (Controller::tokenEstBienFormate() && Controller::formulaireEstValide()) {
    if (Controller::tokenVeritable($_POST['email'], $_GET['token'])) {
        $donneesCryptees = Ordonnanceur::genererDonneesHachees($_POST);
        if (Modele::activerUtilisateur($donneesCryptees)) {
            Controller::supprimerToken($_POST['email']);
            Ordonnanceur::connexionReussie($_POST);
        } else {
            Ordonnanceur::finDeTransaction('Les informations saisies dans le formulaire ne sont pas valides ou bien mauvais token associé à cet utilisateur.');
        }
    } else {
        Ordonnanceur::finDeTransaction('
            Voici les causes possibles :
            <ul>
                <li>Les informations saisies dans le formulaire ne sont pas valides</li>
                <li>Mauvais token associé à cet utilisateur.</li>
                <li>Le token a expiré.</li>
            </ul>
        ');
    }
}

$bouton = '<button class="btn waves-effect waves-light green" type="submit" name="action">Activer
                <i class="material-icons right">send</i>
            </button>';
require_once('formulaire.php');