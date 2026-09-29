<?php

namespace App\Providers;

use App\Enums\TripType;
use App\Services\Pricing\PricingPolicyResolver;
use App\Services\Pricing\RegularPricingPolicy;
use App\Services\Pricing\VipPricingPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PricingPolicyResolver::class, function () {
            return new PricingPolicyResolver([
                TripType::Regular->value => new RegularPricingPolicy(),
                TripType::Vip->value => new VipPricingPolicy(
                    config('booking.vip_multiplier')
                ),
            ]);
        });
    }

    public function boot(): void
    {
        //
    }
}