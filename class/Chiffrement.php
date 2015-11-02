<?php

class Chiffrement
{
    public static function chiffrer($str)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(_ALGO_CHIFFREMENT_));
        $encrypted = openssl_encrypt($str, _ALGO_CHIFFREMENT_, self::genererCle(), OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encrypted);

    }

    public static function dechiffrer($str)
    {
        $ciphertext_dec = base64_decode($str);
        $iv_dec = substr($ciphertext_dec, 0, self::$iv_size);
        $ciphertext_dec = substr($ciphertext_dec, self::$iv_size);
        return openssl_decrypt($ciphertext_dec, _ALGO_CHIFFREMENT_, self::genererCle(), OPENSSL_RAW_DATA, $iv_dec);
    }

    private static function genererCle()
    {
        return pack('H*', md5($_SESSION['motDePasse'] . $_SESSION['pin']));
    }

    private static $iv_size = 16;
}