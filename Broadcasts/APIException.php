<?php


namespace pimax\Broadcasts;


use LogicException;
use Throwable;

class APIException extends LogicException
{
    public $error = [];

    public function __construct (array $fbError)
    {
        $this -> error = $fbError;
        parent::__construct($fbError['message'], $fbError['error_subcode']);
    }
}