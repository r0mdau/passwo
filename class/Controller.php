<?php

class Controller
{
    public static function formulaireEstValide()
    {
        return isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['password']) && !empty($_POST['password']) &&
        isset($_POST['pin']) && !empty($_POST['pin']) &&
        self::mailEstValide($_POST['email']) &&
        self::passwordEstValide($_POST['password']) &&
        self::pinEstValide($_POST['pin']);
    }

    public static function mailEstValide($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function passwordEstValide($password)
    {
        return strlen($password) >= _PASSWORD_TAILLE_REQUISE_;
    }

    public static function pinEstValide($pin)
    {
        return preg_match('/^[0-9]{4}$/', $pin);
    }

    public static function tokenEstBienFormate()
    {
        return isset($_GET['token']) && !empty($_GET['token']) && preg_match('/^[a-z0-9]{'._TOKEN_TAILLE_.'}$/i', $_GET['token']);
    }

    public static function tokenVeritable($email, $token)
    {
        $booleenFetch = false;
        $tokenApc = apc_fetch($email, $booleenFetch);
        return $booleenFetch && $tokenApc == $token;
    }

    public static function supprimerToken($email)
    {
        apc_delete($email);
    }
}