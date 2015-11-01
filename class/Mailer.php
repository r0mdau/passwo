<?php

class Mailer
{
    public static function envoyerPourCreation($email)
    {
        $token = bin2hex(mcrypt_create_iv(256, MCRYPT_DEV_URANDOM));
        $token = substr($token, rand(1, 255), _TOKEN_TAILLE_);

        apc_store($email, $token, _TOKEN_DUREE_VIE_);
        $sujet = 'Activation de votre compte';
        $enTete = array(
            "MIME-Version: 1.0",
            "Content-type: text/html; charset=utf-8",
            "From: " . _APP_NOM_ . " <admin@passwho.romaindauby.fr>",
            "X-Mailer: PHP/" . phpversion()
        );
        $enTete = implode("\r\n", $enTete);

        $message = '<body>';
        $message .= '<p>Allez sur ce lien pour activer votre compte <a href="http://' . _APP_URI_ . '/activer?token=' . $token . '">http://' . _APP_URI_ . '/activer</a></p>';
        $message .= '<p>Ce lien a une durée de vie de 15 minutes.</p>';
        $message .= '<p>Si vous n\'arrivez pas à activer votre compte, patientez donc 15 minutes pour relancer le processus.</p>';
        $message .= '</body>';
        return mail($email, $sujet, $message, $enTete);
    }
}