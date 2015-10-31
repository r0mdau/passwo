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
            'password' => Hash::whirlpool($data['password']),
            'pin' => Hash::whirlpool($data['pin'])
        );
    }

    public static function connexionReussie($data)
    {
        $_SESSION = array(
            'dateCreationSession' => new DateTime(),
            'email' => $data['email'],
            'password' => $data['password'],
            'pin' => $data['pin']
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
}