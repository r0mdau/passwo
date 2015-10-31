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
        return strlen($password) >= 1;
    }

    public static function pinEstValide($pin)
    {
        return preg_match('/[0-9]{4}/', $pin);
    }
}