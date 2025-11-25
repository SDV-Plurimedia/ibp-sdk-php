<?php

namespace SdV\Ibp\Exceptions;

use Exception;
use SdV\Ibp\Resources\Error;

class ApiException extends Exception
{
    public function __construct(string $message, public Error $error)
    {
        parent::__construct($message);
    }
}
