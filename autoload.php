<?php
function loadDir($dir){
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if(strpos($file, '.php') !== false){
                require_once($dir.$file);
            }
        }
        closedir($dh);
    }
}
function autoload(){
    loadDir(__DIR__.'/class/');
}
spl_autoload_register('autoload');