<?php

class Token
{
    public static function creer()
    {
        $token = bin2hex(mcrypt_create_iv(256, MCRYPT_DEV_URANDOM));
        return substr($token, mt_rand(1, 255), mt_rand(_TOKEN_TAILLE_MIN_, _TOKEN_TAILLE_MAX_));
    }

    public static function persister($email, $token)
    {
        return apc_store($email, $token, _TOKEN_DUREE_VIE_);
    }

    public static function recuperer($email, &$booleenFetch)
    {
        return apc_fetch($email, $booleenFetch);
    }

    public static function supprimer($email)
    {
        return apc_delete($email);
    }
}