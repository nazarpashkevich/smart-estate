<?php

namespace App\Domains\Search\Services;

use App\Domains\Common\Values\SortValue;
use App\Domains\Search\Factories\ElasticSearchFactory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SearchService
{

    /**
     * @param  string                                     $model
     * @param  \Illuminate\Support\Collection             $filters
     * @param  \App\Domains\Common\Values\SortValue|null  $sort
     * @param  int                                        $page
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function search(
        string $model,
        Collection $filters = new Collection(),
        ?SortValue $sort = null,
        int $page = 1
    ): LengthAwarePaginator {
        $searchQuery = ElasticSearchFactory::init(new $model())
            ->applyFilters($filters);

        if ($sort instanceof SortValue) {
            $searchQuery->applySort($sort);
        }

        return $searchQuery->paginate($page);
    }
}
