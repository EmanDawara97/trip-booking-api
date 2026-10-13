<?php

namespace App\Http\Controllers;

use App\Http\Resources\SeatResource;
use App\Http\Resources\TripResource;
use App\Models\Trip;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::with(['origin', 'destination'])
            ->orderBy('departure_at')
            ->paginate(10);

        return TripResource::collection($trips)->additional(['success' => true]);
    }

    public function show(Trip $trip)
    {
        $trip->load(['origin', 'destination']);

        return (new TripResource($trip))->additional(['success' => true]);
    }

    public function availableSeats(Trip $trip)
    {
        $seats = $trip->availableSeats()->orderBy('seat_number')->get();

        return SeatResource::collection($seats)->additional(['success' => true]);
    }
}