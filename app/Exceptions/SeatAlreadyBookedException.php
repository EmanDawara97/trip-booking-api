<?php

namespace App\Exceptions;

class SeatAlreadyBookedException extends BookingException
{
    protected int $statusCode = 409;

    public function __construct()
    {
        parent::__construct('This seat is already booked.');
    }
}