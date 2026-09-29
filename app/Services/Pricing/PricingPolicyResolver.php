<?php

namespace App\Services\Pricing;

use App\Contracts\PricingPolicyInterface;
use App\Models\Trip;

class PricingPolicyResolver
{
    /** @param array<string, PricingPolicyInterface> $policies */
    public function __construct(private array $policies) {}

    public function for(Trip $trip): PricingPolicyInterface
    {
        return $this->policies[$trip->type->value];
    }
}