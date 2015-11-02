<?php
session_start();

require_once('../autoload.php');

if (!isset($_SESSION['dateCreationSession']) || Controller::sessionExpiree()) Ordonnanceur::redirigerVers('/');

if (Controller::formulaireAjoutMotDePasseEstValide($_POST)) {
    Ordonnanceur::ajouterMotDePasse($_POST);
}

if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    Ordonnanceur::supprimerMotDePasse((int) $_GET['delete']);
}

Ordonnanceur::redirigerVers('/administrer');