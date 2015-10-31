<?php

class Mailer
{
    public static function envoyerPourCreation($email)
    {
        $sujet = _APP_NOM_ . ' activation compte';
        $enTete = array(
            "MIME-Version: 1.0",
            "Content-type: text/plain; charset=iso-8859-1",
            "From: Admin <admin@passwho.com>",
            "X-Mailer: PHP/" . phpversion()
        );
        $enTete = implode("\r\n", $enTete);

        $message = 'YEAH BABYY';
        return mail($email, $sujet, $message, $enTete);
    }
}