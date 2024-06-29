<?php

namespace App\Domains\Estate\Filters;

use App\Domains\Common\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class RoomsFilter extends Filter
{
    public function filter(Builder $query): Builder
    {
        return $query->where('rooms', $this->value);
    }
}
