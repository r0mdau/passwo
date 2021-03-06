<?php

class Mailer
{
    public static function envoyerPourCreation($email)
    {
        $token = Token::creer();
        Token::persister($email, $token);

        $sujet = 'Activation de votre compte';
        $enTete = array(
            "MIME-Version: 1.0",
            "Content-type: text/html; charset=utf-8",
            "From: " . _APP_NOM_ . " <" . _ADMIN_MAIL_ . ">",
            "Reply-To: " . _APP_NOM_ . " <" . _ADMIN_MAIL_ . ">",
            "X-Mailer: PHP/" . phpversion()
        );
        $enTete = implode("\r\n", $enTete);

        $message =  '<body>';
        $message .= '<p>Cliquez sur ce lien pour activer votre compte <a href="http://' . _APP_URI_ . '/activer?token=' . $token . '">http://' . _APP_URI_ . '/activer</a></p>';
        $message .= '<p>Ce lien a une durée de vie de 15 minutes.</p>';
        $message .= '<p>Si vous n\'arrivez pas à activer votre compte, patientez donc 15 minutes avant de relancer le processus de création de compte.</p>';
        $message .= '</body>';
        return mail($email, $sujet, $message, $enTete);
    }
}