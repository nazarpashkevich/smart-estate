<?php

namespace App\Domains\Estate\Filters\EstateApplication;

use App\Domains\Common\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class StatusFilter extends Filter
{
    public function filter(Builder $query): Builder
    {
        return $query->where('status', $this->value);
    }
}
