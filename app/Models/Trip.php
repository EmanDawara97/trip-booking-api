<?php

namespace App\Models;

use App\Enums\TripType;
use App\Models\Concerns\HasSeatAvailability;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasSeatAvailability;

    protected $fillable = [
        'origin_city_id', 'destination_city_id',
        'departure_at', 'type', 'base_price',
    ];

    protected function casts(): array
    {
        return [
            'type' => TripType::class,
            'departure_at' => 'datetime',
        ];
    }

    public function origin()
    {
        return $this->belongsTo(City::class, 'origin_city_id');
    }

    public function destination()
    {
        return $this->belongsTo(City::class, 'destination_city_id');
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}