<?php

namespace App\Domains\Estate\Filters\EstateItem;

use App\Domains\Common\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class PriceFromFilter extends Filter
{
    public function filter(Builder $query): Builder
    {
        return $query->where('price', '>=', $this->value);
    }
}
