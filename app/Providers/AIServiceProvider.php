<?php

namespace App\Providers;

use App\Domains\AI\Assistants\AIAssistant;
use App\Domains\AI\Assistants\Llama3Assistant;
use App\Domains\AI\Contracts\AssistantMessageResolver;
use App\Domains\AI\Resolvers\MessageResolvers\GeneralAssistantMessageResolver;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AIServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(AIAssistant::class, Llama3Assistant::class);

        $this->app->bind(Llama3Assistant::class, function ($app) {
            return new Llama3Assistant(Http::withQueryParameters([])
                ->baseUrl(config('services.ai.host'))
                ->timeout(60 * 20)
            );
        });
        $this->app->bind(AssistantMessageResolver::class, GeneralAssistantMessageResolver::class);
    }
}
