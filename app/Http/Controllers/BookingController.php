<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Trip;
use App\Services\BookingService;

class BookingController extends Controller
{
    public function __construct(private BookingService $bookings) {}

    public function store(StoreBookingRequest $request, Trip $trip)
    {
        $booking = $this->bookings->book($trip, $request->integer('seat_id'), [
            'name' => $request->validated('customer_name'),
            'phone' => $request->validated('customer_phone'),
        ]);

        return $this->respond($booking, 201);
    }

    public function show(Booking $booking)
    {
        return $this->respond($booking);
    }

    public function confirm(Booking $booking)
    {
        return $this->respond($this->bookings->confirm($booking));
    }

    public function cancel(Booking $booking)
    {
        return $this->respond($this->bookings->cancel($booking));
    }

    private function respond(Booking $booking, int $status = 200)
    {
        $booking->load(['customer', 'seat']);

        return (new BookingResource($booking))
            ->additional(['success' => true])
            ->response()
            ->setStatusCode($status);
    }
}