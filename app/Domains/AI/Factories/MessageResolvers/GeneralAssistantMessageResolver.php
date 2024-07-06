<?php

namespace App\Domains\AI\Factories\MessageResolvers;

use App\Domains\AI\Contracts\AssistantMessageResolver;
use App\Domains\Estate\Models\EstateItem;
use App\Domains\Search\Services\SearchService;
use Illuminate\Support\Str;

class GeneralAssistantMessageResolver implements AssistantMessageResolver
{
    public function __construct(protected SearchService $searchService)
    {
    }

    /**
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     */
    public function resolve(string $message): string
    {
        return Str::replace(['<APPARTMENTS_DATA>'], [$this->getApartmentsData()], $message);
    }

    /**
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     */
    public function getApartmentsData(): string
    {
        return $this->searchService->search(EstateItem::class)->toJson();
    }
}
