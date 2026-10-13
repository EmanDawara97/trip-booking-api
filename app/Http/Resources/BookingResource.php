<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'trip_id' => $this->trip_id,
            'seat_number' => $this->whenLoaded('seat', fn () => $this->seat->seat_number),
            'customer' => $this->whenLoaded('customer', fn () => [
                'name' => $this->customer->name,
                'phone' => $this->customer->phone,
            ]),
            'status' => $this->status->value,
            'price' => (float) $this->price,
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}