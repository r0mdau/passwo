<?php

class Hash
{
    public static function whirlpool($str)
    {
        return hash('whirlpool', $str, true);
    }
}