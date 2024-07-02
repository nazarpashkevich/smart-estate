<?php

namespace App\Domains\Search\Factories;

use App\Domains\Common\Filters\Filter;
use App\Domains\Common\Values\SortValue;
use App\Domains\Search\Contracts\ElasticSearchFilterable;
use Elastic\Elasticsearch\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use stdClass;

class ElasticSearchFactory
{
    protected array $queryParams = [];
    private Client $elasticsearch;

    protected function __construct(protected Model $model)
    {
        $this->queryParams = [
            'index' => $model->getTable(),
            'type'  => '_doc',
            'body'  => [],
        ];

        $this->elasticsearch = app(Client::class);
    }

    public static function init(Model $model): static
    {
        return new static($model);
    }

    public function applyFilters(Collection $filters): static
    {
        $this->queryParams['body'] = $this->makeQueryFromFilters($filters);

        return $this;
    }

    protected function makeQueryFromFilters(Collection $filters): array
    {
        // transform local filters to elasticsearch
        $elFilters = $filters->filter(fn (Filter $filter) => $filter instanceof ElasticSearchFilterable)
            ->whereNotNull();

        if ($elFilters->isEmpty()) {
            return [];
        }

        $filters = [];

        $elFilters->each(function (ElasticSearchFilterable $filter) use (&$filters) {
            $filters[$filter->isFilter() ? 'filter' : 'must'][] = $filter->elasticFilter();
        });

        return ['query' => ['bool' => $filters]];
    }

    public function applySort(SortValue $sort): static
    {
        return $this;
    }

    /**
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     */
    public function paginate(int $page): LengthAwarePaginator
    {
        $perPage = $this->model->getPerPage();

        $this->queryParams['size'] = $perPage;
        $this->queryParams['from'] = ($page * $perPage) - $perPage;

        $items = $this->get();

        $hits = $items?->hits;

        return new LengthAwarePaginator(
            Arr::map($hits?->hits ?? [], fn ($hit) => $hit->_id),
            $hits->total->value,
            $perPage,
            $page
        );
    }

    /**
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     */
    public function get(): stdClass
    {
        return $this->elasticsearch->search($this->queryParams)->asObject();
    }
}
