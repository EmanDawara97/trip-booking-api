<?php

namespace App\Exceptions;

class BookingAlreadyCancelledException extends BookingException
{
    protected int $statusCode = 409;

    public function __construct()
    {
        parent::__construct('This booking is already cancelled.');
    }
}