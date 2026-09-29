<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Exceptions\BookingAlreadyCancelledException;
use App\Exceptions\InvalidBookingStatusException;
use App\Exceptions\SeatAlreadyBookedException;
use App\Exceptions\SeatNotInTripException;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Seat;
use App\Models\Trip;
use App\Services\Pricing\PricingPolicyResolver;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function __construct(private PricingPolicyResolver $pricing) {}

    public function book(Trip $trip, int $seatId, array $customerData): Booking
    {
        return DB::transaction(function () use ($trip, $seatId, $customerData) {
            
            $seat = Seat::whereKey($seatId)->lockForUpdate()->firstOrFail();

            if ($seat->trip_id !== $trip->id) {
                throw new SeatNotInTripException();
            }

            $taken = $seat->bookings()
                ->whereIn('status', BookingStatus::activeValues())
                ->exists();

            if ($taken) {
                throw new SeatAlreadyBookedException();
            }

            $customer = Customer::firstOrCreate(
                ['phone' => $customerData['phone']],
                ['name' => $customerData['name']]
            );

            return Booking::create([
                'customer_id' => $customer->id,
                'trip_id' => $trip->id,
                'seat_id' => $seat->id,
                'status' => BookingStatus::Pending,
                'price' => $this->pricing->for($trip)->calculate($trip),
            ]);
        });
    }

    public function confirm(Booking $booking): Booking
    {
        if ($booking->status !== BookingStatus::Pending) {
            throw new InvalidBookingStatusException('Only pending bookings can be confirmed.');
        }

        $booking->update(['status' => BookingStatus::Confirmed]);

        return $booking;
    }

    public function cancel(Booking $booking): Booking
    {
        if ($booking->status === BookingStatus::Cancelled) {
            throw new BookingAlreadyCancelledException();
        }

        $booking->update(['status' => BookingStatus::Cancelled]);

        return $booking;
    }
}