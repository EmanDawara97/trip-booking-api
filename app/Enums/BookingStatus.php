<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';

    public static function activeValues(): array
    {
        return [self::Pending->value, self::Confirmed->value];
    }
}