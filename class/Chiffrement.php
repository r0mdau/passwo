<?php

class Chiffrement
{
    public static function chiffrer($str)
    {
        $iv = mcrypt_create_iv(self::$iv_size, MCRYPT_RAND);
        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, self::genererCle(), $str, MCRYPT_MODE_CBC, $iv);
        return $iv . $ciphertext;
    }

    public static function dechiffrer($ciphertext_dec)
    {
        $iv_dec = substr($ciphertext_dec, 0, self::$iv_size);
        $ciphertext_dec = substr($ciphertext_dec, self::$iv_size);
        $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, self::genererCle(), $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
        return $plaintext_dec;
    }

    private static function genererCle()
    {
        return pack('H*', md5($_SESSION['password'] . $_SESSION['pin']));
    }

    private static $iv_size = 32;
}