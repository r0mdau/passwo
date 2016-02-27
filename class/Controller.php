<?php

class Controller
{
    public static function formulaireEstValide($donnees)
    {
        return isset($donnees['email']) && !empty($donnees['email']) &&
        isset($donnees['motDePasse']) && !empty($donnees['motDePasse']) &&
        isset($donnees['pin']) && !empty($donnees['pin']) &&
        self::mailEstValide($donnees['email']) &&
        self::motDePasseEstValide($donnees['motDePasse']) &&
        self::pinEstValide($donnees['pin']);
    }

    public static function formulaireAjoutMotDePasseEstValide($donnees)
    {
        return isset($donnees['libelle']) && !empty($donnees['libelle']) &&
        isset($donnees['motDePasse']) && !empty($donnees['motDePasse']);
    }

    public static function mailEstValide($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function motDePasseConfirme($donnees)
    {
        return isset($donnees['confirmationMotDePasse']) &&
        $donnees['motDePasse'] == $donnees['confirmationMotDePasse'];
    }

    public static function motDePasseEstValide($motDePasse)
    {
        return strlen($motDePasse) >= _MOTDEPASSE_TAILLE_REQUISE_;
    }

    public static function pinEstValide($pin)
    {
        return preg_match('/^[0-9]{4}$/', $pin);
    }

    public static function tokenEstBienFormate($token)
    {
        return isset($token) && !empty($token) && preg_match('/^[a-z0-9]{' . _TOKEN_TAILLE_MIN_ . ',' . _TOKEN_TAILLE_MAX_ . '}$/i', $token);
    }

    public static function tokenVeritable($email, $token)
    {
        $booleenFetch = false;
        $tokenApc = Token::recuperer($email, $booleenFetch);
        return $booleenFetch && $tokenApc == $token;
    }

    public static function sessionExpiree()
    {
        $datePassee = new DateTime();
        $datePassee->sub(new DateInterval(_SESSION_DUREE_VIE_));
        return $_SESSION['dateCreationSession'] < $datePassee;
    }
}