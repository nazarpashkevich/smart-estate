<?php

namespace App\Domains\Search\Traits\Model;

use App\Domains\Search\Observers\ElasticSearchObserver;
use Elastic\Elasticsearch\Client;

trait Searchable
{
    public static function bootSearchable(): void
    {
        static::observe(ElasticsearchObserver::class);
    }

    public function elasticsearchIndex(): void
    {
        app(Client::class)->index([
            'index' => $this->getTable(),
            'type'  => '_doc',
            'id'    => $this->getKey(),
            'body'  => $this->toElasticsearchDocumentArray(),
        ]);
    }

    abstract public function toElasticsearchDocumentArray(): array;

    public function elasticsearchDelete(): void
    {
        app(Client::class)->delete([
            'index' => $this->getTable(),
            'type'  => '_doc',
            'id'    => $this->getKey(),
        ]);
    }
}
