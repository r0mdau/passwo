<?php

class Data
{
    private static function connect()
    {
        self::$bdd = new PDO('mysql:host=localhost;port=3306;dbname=passwho', 'root', 'root', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    }

    public static function userExist($data)
    {
        self::connect();
        $req = self::$bdd->prepare('SELECT id FROM compte WHERE email = :email AND password = :password AND pin = :pin AND estActif = 1');

        $req->execute(array(
            'email' => $data['email'],
            'password' => $data['password'],
            'pin' => $data['pin']
        ));
        $results = $req->fetchAll();
        return empty($results) ? false : true;
    }

    public static function createUser($data)
    {
        self::connect();
        $req = self::$bdd->prepare('INSERT INTO compte (email, password, pin) VALUES(:email, :password, :pin)');

        $state = $req->execute(array(
            'email' => $data['email'],
            'password' => $data['password'],
            'pin' => $data['pin']
        ));
        return $state === false ? false : true;
    }

    private static $bdd;

}