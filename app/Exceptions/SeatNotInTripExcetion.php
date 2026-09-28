<?php

namespace App\Exceptions;

class SeatNotInTripException extends BookingException
{
    protected int $statusCode = 422;

    public function __construct()
    {
        parent::__construct('The selected seat does not belong to this trip.');
    }
}