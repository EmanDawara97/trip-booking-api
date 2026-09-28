<?php

namespace App\Exceptions;

use Exception;

abstract class BookingException extends Exception
{
    protected int $statusCode = 400;

    public function statusCode(): int
    {
        return $this->statusCode;
    }
}