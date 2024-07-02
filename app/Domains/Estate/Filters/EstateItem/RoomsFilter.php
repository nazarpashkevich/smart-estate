<?php

namespace App\Domains\Estate\Filters\EstateItem;

use App\Domains\Common\Filters\Filter;
use App\Domains\Search\Contracts\ElasticSearchFilterable;
use App\Domains\Search\Traits\Filter\ElasticSearchFilter;
use Illuminate\Database\Eloquent\Builder;

class RoomsFilter extends Filter implements ElasticSearchFilterable
{
    use ElasticSearchFilter;

    public function filter(Builder $query): Builder
    {
        return $query->where('rooms', $this->value);
    }

    public function elasticField(): string
    {
        return 'rooms';
    }
}
