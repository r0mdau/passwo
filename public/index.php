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
    } else if (Controller::motDePasseConfirme($_POST) && Ordonnanceur::creerCompte($donneesChiffrees, $_POST['email'])) {
        Ordonnanceur::finDeTransaction('Votre compte a été créé.<br>Nous vous avons envoyé un email, veuillez suivre les instructions de celui-ci.', 'Success');
    } else {
        Ordonnanceur::finDeTransaction('
            Causes possibles :
            <ul>
                <li>Un problème est survenu lors de la connexion ou la création de votre compte.</li>
                <li>Vous n\'avez pas activé votre compte, vérifiez vos emails.</li>
                <li>Vous avez peut-être déjà créé un compte mais il n\'est pas actif car votre token est périmé.</li>
                <li>Vous devez confirmer votre mot de passe lors de l\'inscription</li>
            </ul>
        ');
    }
}

$bouton = Vue::genererBoutonIndex();
$boutonEnregistrement = '<a id="inscription" class="btn waves-effect waves-light cyan">Inscription
    <i class="material-icons perm_identity">perm_identity</i>
</a>';
require_once('formulaire.php');