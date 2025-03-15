<?php

namespace App\Domains\AI\Jobs;

use App\Domains\Estate\Models\EstateItem;
use Elastic\Elasticsearch\Client;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use LLPhant\Embeddings\Document;
use LLPhant\Embeddings\EmbeddingGenerator\Ollama\OllamaEmbeddingGenerator;
use LLPhant\Embeddings\VectorStores\Elasticsearch\ElasticsearchVectorStore;

class ReindexVectorDataJob
{
    use Dispatchable, SerializesModels;


    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(
        OllamaEmbeddingGenerator $embeddingGenerator,
        ElasticsearchVectorStore $vectorStore,
        Client $client
    ): void {
        // clear store
        $client->deleteByQuery([
            'index' => $vectorStore->indexName,
            'body'  => ['query' => ['match_all' => new \stdClass()]],
        ]);

        // add new documents
        $embeddedDocuments = $embeddingGenerator->embedDocuments(
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

        $vectorStore->addDocuments($embeddedDocuments);
    }
}

