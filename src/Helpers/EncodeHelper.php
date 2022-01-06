<?php


namespace Overstar\PhpNacos\Helpers;



class EncodeHelper
{
    public static function twoEncode()
    {
        return pack("C*", 2);
    }

    public static function oneEncode()
    {
        return pack("C*", 1);
    }
}