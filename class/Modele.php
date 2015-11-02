<?php

class Modele
{
    private static function connect()
    {
        self::$bdd = new PDO(
            'mysql:host=' . _DB_SERVEUR_ . ';port=' . _DB_PORT_ . ';dbname=' . _DB_NOM_,
            _DB_UTILISATEUR_, _DB_MOTDEPASSE_, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
        );
    }

    public static function utilisateurActifExiste($data)
    {
        self::connect();
        $req = self::$bdd->prepare('SELECT id FROM utilisateur WHERE email = :email AND motDePasse = :motDePasse AND pin = :pin AND estActif = 1');

        $etat = $req->execute(array(
            'email' => $data['email'],
            'motDePasse' => $data['motDePasse'],
            'pin' => $data['pin']
        ));
        return $etat && $req->rowCount() == 1;
    }

    public static function activerUtilisateur($data)
    {
        self::connect();
        $req = self::$bdd->prepare('UPDATE utilisateur SET estActif = 1 WHERE email = :email AND motDePasse = :motDePasse AND pin = :pin AND estActif = 0');

        $etat = $req->execute(array(
            'email' => $data['email'],
            'motDePasse' => $data['motDePasse'],
            'pin' => $data['pin']
        ));
        return $etat && $req->rowCount() == 1;
    }

    public static function creerUtilisateur($data)
    {
        self::connect();
        $req = self::$bdd->prepare('INSERT INTO utilisateur (email, motDePasse, pin) VALUES(:email, :motDePasse, :pin)');

        $etat = $req->execute(array(
            'email' => $data['email'],
            'motDePasse' => $data['motDePasse'],
            'pin' => $data['pin']
        ));
        return $etat === false ? false : true;
    }

    public static function supprimerUtilisateur($data)
    {
        self::connect();
        $req = self::$bdd->prepare('DELETE FROM utilisateur WHERE email = :email AND motDePasse = :motDePasse AND pin = :pin');
        $etat = $req->execute(array(
            'email' => $data['email'],
            'motDePasse' => $data['motDePasse'],
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

    public static function recupererMotsDePassesDe($email)
    {
        self::connect();
        $req = self::$bdd->prepare('SELECT mot_de_passe.id id, mot_de_passe.libelle libelle, mot_de_passe.valeur valeur FROM mot_de_passe INNER JOIN utilisateur ON utilisateur.id = mot_de_passe.utilisateur_id WHERE utilisateur.email = :email');
        $req->execute(array(
            'email' => $email
        ));
        return $req->fetchAll();
    }

    public static function recupererIdentifiantUtilisateur($email)
    {
        self::connect();
        $req = self::$bdd->prepare('SELECT id FROM utilisateur WHERE email = :email');

        $req->execute(array(
            'email' => $email
        ));
        $resultat = $req->fetch();
        return isset($resultat['id']) ? $resultat['id'] : null;
    }

    public static function ajouterMotDePasse($id, $libelle, $motDePasse)
    {
        self::connect();
        $req = self::$bdd->prepare('INSERT INTO mot_de_passe (utilisateur_id, libelle, valeur) VALUES(:utilisateur_id, :libelle, :valeur)');

        $etat = $req->execute(array(
            'utilisateur_id' => $id,
            'libelle' => $libelle,
            'valeur' => $motDePasse
        ));
        return $etat === false ? false : true;
    }

    public static function supprimerMotDePasse($identifiantUtilisateur, $identifiantMotDePasse)
    {
        self::connect();
        $req = self::$bdd->prepare('DELETE FROM mot_de_passe WHERE utilisateur_id = :identifiantUtilisateur AND id = :identifiantMotDePasse');
        $etat = $req->execute(array(
            'identifiantUtilisateur' => $identifiantUtilisateur,
            'identifiantMotDePasse' => $identifiantMotDePasse
        ));
        return $etat && $req->rowCount() == 1;
    }

    private static $bdd;
}