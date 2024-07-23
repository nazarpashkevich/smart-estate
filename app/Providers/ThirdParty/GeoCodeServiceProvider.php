<?php

namespace App\Providers\ThirdParty;

use App\Domains\Common\Services\DeepLService;
use App\Domains\Location\Services\GeoCodeService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class GeoCodeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            GeoCodeService::class,
            fn () => new GeoCodeService(Http::withQueryParameters([
                'api_key' => config('services.geocode.key'),
            ])->baseUrl(config('services.geocode.base-url')))
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
