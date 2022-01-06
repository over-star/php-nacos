<?php


namespace Overstar\PhpNacos\Exceptions;


use Exception;


class RequestException extends Exception
{

    public function __construct($message,$code)
    {
        parent::__construct($message,$code);
    }
}