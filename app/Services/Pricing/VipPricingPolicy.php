<?php

namespace App\Services\Pricing;

use App\Contracts\PricingPolicyInterface;
use App\Models\Trip;

class VipPricingPolicy implements PricingPolicyInterface
{
    public function __construct(private float $multiplier) {}

    public function calculate(Trip $trip): float
    {
        return round((float) $trip->base_price * $this->multiplier, 2);
    }
}