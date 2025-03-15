<?php

namespace App\Providers;

use App\Domains\AI\Assistants\AIAssistant;
use App\Domains\AI\Assistants\Llama3Assistant;
use App\Domains\AI\Assistants\Llama3VectorableAssistant;
use App\Domains\AI\Contracts\AssistantMessageResolver;
use App\Domains\AI\Resolvers\MessageResolvers\GeneralAssistantMessageResolver;
use App\LIbraries\LipHant\OllamaChat;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use LLPhant\Embeddings\EmbeddingGenerator\Ollama\OllamaEmbeddingGenerator;
use LLPhant\Embeddings\VectorStores\Elasticsearch\ElasticsearchVectorStore;
use LLPhant\OllamaConfig;

class AIServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(AIAssistant::class, Llama3VectorableAssistant::class);

        $this->app->bind(Llama3Assistant::class, function ($app) {
            return new Llama3Assistant(Http::withQueryParameters([])
                ->baseUrl(config('ai.host'))
                ->timeout(60 * 20)
            );
        });

        $this->app->bind(OllamaEmbeddingGenerator::class, function ($app) {
            $embeddingGeneratorConfig = new OllamaConfig();
            $embeddingGeneratorConfig->model = config('ai.embedding_model');
            $embeddingGeneratorConfig->url = config('ai.host') . '/api/';

            return new OllamaEmbeddingGenerator($embeddingGeneratorConfig);
        });

        $this->app->bind(ElasticsearchVectorStore::class, function ($app) {
            return new ElasticsearchVectorStore(app(Client::class), config('ai.vector_index'));
        });

        $this->app->bind(Llama3VectorableAssistant::class, function ($app) {
            $embeddingGeneratorConfig = new OllamaConfig();
            $embeddingGeneratorConfig->model = config('ai.embedding_model');
            $embeddingGeneratorConfig->url = config('ai.host') . '/api/';

            $config = new OllamaConfig();
            $config->model = config('ai.model');
            $config->url = $embeddingGeneratorConfig->url;
            $config->modelOptions = [
                'num_ctx'     => 8192, // @todo move to config
                'temperature' => 0.7,
                'top_k'       => 20,
                'top_p'       => 0.8,
            ];

            return new Llama3VectorableAssistant(
                new OllamaChat($config),
                app(OllamaEmbeddingGenerator::class),
                app(ElasticsearchVectorStore::class),
            );
        });

        $this->app->bind(AssistantMessageResolver::class, GeneralAssistantMessageResolver::class);
    }
}
