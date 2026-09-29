<?php

namespace App\Services\Pricing;

use App\Contracts\PricingPolicyInterface;
use App\Models\Trip;

class RegularPricingPolicy implements PricingPolicyInterface
{
    public function calculate(Trip $trip): float
    {
        return round((float) $trip->base_price, 2);
    }
}