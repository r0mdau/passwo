<?php

class Modele
{
    private static function connect()
    {
        self::$bdd = new PDO(
            'mysql:host=' . _DB_SERVEUR_ . ';port=' . _DB_PORT_ . ';dbname=' . _DB_NOM_,
            _DB_UTILISATEUR_, _DB_PASSWORD_, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
        );
    }

    public static function utilisateurActifExiste($data)
    {
        self::connect();
        $req = self::$bdd->prepare('SELECT id FROM utilisateur WHERE email = :email AND password = :password AND pin = :pin AND estActif = 1');

        $etat = $req->execute(array(
            'email' => $data['email'],
            'password' => $data['password'],
            'pin' => $data['pin']
        ));
        return $etat && $req->rowCount() == 1;
    }

    public static function activerUtilisateur($data)
    {
        self::connect();
        $req = self::$bdd->prepare('UPDATE utilisateur SET estActif = 1 WHERE email = :email AND password = :password AND pin = :pin AND estActif = 0');

        $etat = $req->execute(array(
            'email' => $data['email'],
            'password' => $data['password'],
            'pin' => $data['pin']
        ));
        return $etat && $req->rowCount() == 1;
    }

    public static function creerUtilisateur($data)
    {
        self::connect();
        $req = self::$bdd->prepare('INSERT INTO utilisateur (email, password, pin) VALUES(:email, :password, :pin)');

        $etat = $req->execute(array(
            'email' => $data['email'],
            'password' => $data['password'],
            'pin' => $data['pin']
        ));
        return $etat === false ? false : true;
    }

    public static function supprimerUtilisateur($data)
    {
        self::connect();
        $req = self::$bdd->prepare('DELETE FROM utilisateur WHERE email = :email AND password = :password AND pin = :pin');
        $etat = $req->execute(array(
            'email' => $data['email'],
            'password' => $data['password'],
            'pin' => $data['pin']
        ));
        return $etat && $req->rowCount() == 1;
    }

    public static function supprimerAnciensComptesInactifs()
    {
        self::connect();
        $req = self::$bdd->prepare('DELETE FROM utilisateur WHERE estActif = 0 AND creation < DATE_SUB(NOW(), INTERVAL ' . _TOKEN_DUREE_VIE_ . ' SECOND )');
        $etat = $req->execute();
        return $etat && $req->rowCount() == 1;
    }

    private static $bdd;
}