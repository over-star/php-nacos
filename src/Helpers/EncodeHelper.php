<?php


namespace Overstar\PhpNacos\Helpers;



class EncodeHelper
{
    //把2填充到二进制流中
    public static function twoEncode()
    {
        return pack("C*", 2);
    }

    public static function oneEncode()
    {
        return pack("C*", 1);
    }
}