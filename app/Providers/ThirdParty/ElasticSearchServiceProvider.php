<?php

namespace App\Providers\ThirdParty;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class ElasticSearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts(config('services.search.hosts'))
                ->setSSLVerification(false)
                ->build();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
