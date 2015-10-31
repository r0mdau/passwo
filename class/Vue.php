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
    }}