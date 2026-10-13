<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'origin' => $this->origin->name,
            'destination' => $this->destination->name,
            'departure_at' => $this->departure_at->toIso8601String(),
            'type' => $this->type->value,
            'base_price' => (float) $this->base_price,
            'available_seats' => $this->availableSeatsCount(),
        ];
    }
}