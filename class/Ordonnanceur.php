<?php

class Ordonnanceur
{
    public static function creerCompte($crypted, $email)
    {
        if (!Modele::creerUtilisateur($crypted)) return false;
        if (!Mailer::envoyerPourCreation($email)) {
            Modele::supprimerUtilisateur($crypted);
            return false;
        }

        return true;
    }

    public static function supprimerComptesInactifs()
    {
        Modele::supprimerAnciensComptesInactifs();
    }

    public static function redirigerVers($uri)
    {
        header('Location: ' . $uri);
        exit;
    }
}