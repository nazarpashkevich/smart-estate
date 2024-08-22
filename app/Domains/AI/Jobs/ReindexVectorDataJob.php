<?php

namespace App\Domains\AI\Jobs;

use App\Domains\Estate\Models\EstateItem;
use Elastic\Elasticsearch\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use LLPhant\Embeddings\Document;
use LLPhant\Embeddings\EmbeddingGenerator\Ollama\OllamaEmbeddingGenerator;
use LLPhant\Embeddings\VectorStores\Elasticsearch\ElasticsearchVectorStore;

class ReindexVectorDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected OllamaEmbeddingGenerator $embeddingGenerator,
        protected ElasticsearchVectorStore $vectorStore,
        protected Client $client,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // clear store
        $this->client->deleteByQuery([
            'index' => $this->vectorStore->indexName,
            'body'  => ['query' => ['match_all' => new \stdClass()]],
        ]);

        // add new documents
        $embeddedDocuments = $this->embeddingGenerator->embedDocuments(
            EstateItem::query()
                ->with('location')
                ->get()
                ->map(function (EstateItem $item): Document {
                    $document = new Document();
                    $document->content = json_encode($item->toVectorStoreArray());

                    return $document;
                })
                ->toArray()
        );

        $this->vectorStore->addDocuments($embeddedDocuments);
    }
}

