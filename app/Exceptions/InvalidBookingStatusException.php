<?php

namespace App\Exceptions;

class InvalidBookingStatusException extends BookingException
{
    protected int $statusCode = 409;

    public function __construct(string $message = 'Booking status does not allow this action.')
    {
        parent::__construct($message);
    }
}