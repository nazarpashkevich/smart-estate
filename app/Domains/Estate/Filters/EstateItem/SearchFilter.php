<?php

namespace App\Domains\Estate\Filters\EstateItem;

use App\Domains\Common\Filters\Filter;
use App\Domains\Search\Contracts\ElasticSearchFilterable;
use Illuminate\Database\Eloquent\Builder;

class SearchFilter extends Filter implements ElasticSearchFilterable
{
    public function filter(Builder $query): Builder
    {
        return $query->where('description', 'LIKE', $this->value);
    }

    public function elasticFilter(): array
    {
        return [
            'multi_match' => [
                'query'  => $this->value,
                'fields' => ['*'],
            ],
        ];
    }

    public function elasticField(): string
    {
        return '';
    }

    public function isFilter(): bool
    {
        return false;
    }
}
