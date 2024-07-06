<?php

namespace App\Providers;

use App\Domains\AI\Contracts\AssistantMessageResolver;
use App\Domains\AI\Factories\Assistants\AIAssistantChatFactory;
use App\Domains\AI\Factories\Assistants\Llama3AssistantFactory;
use App\Domains\AI\Factories\MessageResolvers\GeneralAssistantMessageResolver;
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
        $this->app->bind(AIAssistantChatFactory::class, Llama3AssistantFactory::class);

        $this->app->bind(Llama3AssistantFactory::class, function ($app) {
            return new Llama3AssistantFactory(Http::withQueryParameters([])
                ->baseUrl(config('services.ai.host'))
                ->timeout(60 * 20)
            );
        });
        $this->app->bind(AssistantMessageResolver::class, GeneralAssistantMessageResolver::class);
    }
}
