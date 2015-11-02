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

    public static function genererDonneesHachees($data)
    {
        return array(
            'email' => Hash::whirlpool($data['email']),
            'motDePasse' => Hash::whirlpool($data['motDePasse']),
            'pin' => Hash::whirlpool($data['pin'])
        );
    }

    public static function connexionReussie($data, $donneesChiffrees)
    {
        $_SESSION = array(
            'id' => Modele::recupererIdentifiantUtilisateur($donneesChiffrees['email']),
            'dateCreationSession' => new DateTime(),
            'email' => $data['email'],
            'motDePasse' => $data['motDePasse'],
            'pin' => $data['pin'],
            'chiffree' => $donneesChiffrees
        );
        self::redirigerVers('/administrer');
    }

    public static function finDeTransaction($message = '', $type = 'Erreur')
    {
        $_SESSION = array(
            'informations' => array(
                'type' => $type,
                'message' => $message
            )
        );
        self::redirigerVers('/');
    }

    public static function redirigerVers($uri)
    {
        header('Location: ' . $uri);
        exit;
    }

    public static function ajouterMotDePasse($donnees)
    {
        Modele::ajouterMotDePasse(
            $_SESSION['id'],
            Chiffrement::chiffrer($donnees['libelle']),
            Chiffrement::chiffrer($donnees['motDePasse'])
        );
        self::redirigerVers('/administrer');
    }

    public static function supprimerMotDePasse($identifiantMotDePasse)
    {
        Modele::supprimerMotDePasse($_SESSION['id'], $identifiantMotDePasse);
    }
}