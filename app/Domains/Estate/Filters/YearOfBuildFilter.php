<?php

namespace App\Domains\Estate\Filters;

use App\Domains\Common\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class YearOfBuildFilter extends Filter
{
    public function filter(Builder $query): Builder
    {
        return $query->where('year_of_build', $this->value);
    }
}
