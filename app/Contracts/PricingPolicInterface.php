<?php

namespace App\Contracts;

use App\Models\Trip;

interface PricingPolicyInterface
{
    public function calculate(Trip $trip): float;
}