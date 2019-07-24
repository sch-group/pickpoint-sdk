<?php

namespace PickPointSdk\Exceptions;

use Throwable;

class PickPointMethodCallException extends \Exception
{
    public function __construct($urlCall = "", $message = "", $code = 0, Throwable $previous = null)
    {
        $message = "Exception in api method: " . $urlCall . " with Error code: " . $code . " with message: " . $message;
        parent::__construct($message, $code, $previous);
    }
}