<?php

class Vue
{
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

    private static function genererBouton($nom, $couleur = '')
    {
        return '<button class="btn waves-effect waves-light '.$couleur.'" type="submit" name="action">'.$nom.'
                <i class="material-icons right">send</i>
            </button>';
    }

    public static function genererBoutonIndex()
    {
        return self::genererBouton('Connexion');
    }

    public static function genererBoutonActiver()
    {
        return self::genererBouton('Activer', 'green');
    }
}