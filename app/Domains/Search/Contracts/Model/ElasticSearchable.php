<?php

namespace App\Domains\Search\Contracts\Model;

interface ElasticSearchable
{
    public function elasticsearchIndex(): void;

    public function toElasticsearchDocumentArray(): array;

    public function elasticsearchDelete(): void;

    public function getQueueableId();

}
