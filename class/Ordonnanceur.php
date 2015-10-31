<?php

class Ordonnanceur
{
    public static function creerCompte($crypted, $email)
    {
        if (!Modele::creerUtilisateur($crypted)) return false;
        if (!Mailer::envoyerPourCreation($email)) {
            Modele::supprimerUtilisateur($crypted);
            return false;
        }

        return true;
    }

    public static function supprimerComptesInactifs()
    {
        Modele::supprimerAnciensComptesInactifs();
    }

    public static function finDeTransaction($message = '', $type = 'Erreur')
    {
        $_SESSION = array(
            'informations' => array(
                'type' => $type,
                'message' => $message
            )
        );
        Ordonnanceur::redirigerVers('/');
    }

    public static function redirigerVers($uri)
    {
        header('Location: ' . $uri);
        exit;
    }

    public static function genererCarte()
    {
        $html = '';
        if (isset($_SESSION['informations'])) {
            $html = '
                <div class="row">
                    <div class="col s6 offset-s3">
                        <div class="card ' . ($_SESSION['informations']['type'] == 'Erreur' ? ' red accent-3 ' : ' green ') . '">
                            <div class="card-content white-text">
                                <span class="card-title">' . $_SESSION['informations']['type'] . '</span>
                                <p>' . $_SESSION['informations']['message'] . '</p>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
        return $html;
    }
}