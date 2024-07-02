<?php

namespace App\Domains\Estate\Services;

use App\Domains\Common\Values\SortValue;
use App\Domains\Estate\Builders\EstateItemBuilder;
use App\Domains\Estate\Data\EstateItemData;
use App\Domains\Estate\Models\EstateItem;
use App\Domains\Search\Services\SearchService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class EstateItemService
{

    public function __construct(protected SearchService $searchService)
    {
    }

    public function create(EstateItemData $data): EstateItem
    {
        $estateItem = $data->toModel();
        $estateItem->save();

        return $estateItem;
    }

    public function update(EstateItem $estateItem, EstateItemData $data): EstateItem
    {
        $estateItem = $data->toModel($estateItem);
        $estateItem->save();

        return $estateItem;
    }

    /**
     * @param  \Illuminate\Support\Collection             $filters
     * @param  \App\Domains\Common\Values\SortValue|null  $sort
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator<\App\Domains\Estate\Models\EstateItem>
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function list(Collection $filters = new Collection(), ?SortValue $sort = null): LengthAwarePaginator
    {
        $query = EstateItem::query();
        $query->with('location');

        if (config('services.search.enabled')) { // is elastic enabled?
            return $this->elasticList($query, $filters, $sort);
        }

        $query->filter($filters);

        $sort?->applyTo($query);

        return $query->paginate();
    }

    /**
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function elasticList(
        EstateItemBuilder $query,
        Collection $filters,
        ?SortValue $sort = null
    ): LengthAwarePaginator {
        $page = Paginator::resolveCurrentPage();
        $searchItems = $this->searchService->search(
            EstateItem::class,
            new Collection($query->resolveFilters($filters)),
            $sort,
            $page
        );

        return new LengthAwarePaginator(
            $query->with('location')->whereIn('id', $searchItems->items())->get(),
            $searchItems->total(),
            $searchItems->perPage(),
            $searchItems->currentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
    }
}
