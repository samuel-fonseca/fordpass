<?php

namespace App\Services\Ford\Exceptions;

use Exception;

class FordpassException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
