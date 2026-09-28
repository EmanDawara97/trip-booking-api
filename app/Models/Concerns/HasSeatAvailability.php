<?php

namespace App\Models\Concerns;

use App\Enums\BookingStatus;

trait HasSeatAvailability
{
    public function availableSeats()
    {
        return $this->seats()->whereDoesntHave('bookings', function ($q) {
            $q->whereIn('status', BookingStatus::activeValues());
        });
    }

    public function availableSeatsCount(): int
    {
        return $this->availableSeats()->count();
    }
}