<?php
session_start();

require_once('autoload.php');

if(!isset($_SESSION['email'])) Ordonnanceur::redirigerVers('/');

Ordonnanceur::supprimerComptesInactifs();
?>
coucou