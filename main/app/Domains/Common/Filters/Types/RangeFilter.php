<?php

namespace App\Domains\Common\Filters\Types;

use App\Domains\Common\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

abstract class RangeFilter extends Filter
{
    /**
     * @throws \Exception
     */
    public function resolveValue(mixed $value): void
    {
        if (!is_array($value)) {
            throw new \Exception('Filter value must be an array');
        }
    }

    public function filter(Builder $query): Builder
    {
        return $query->whereBetween($this->getField(), $this->value);
    }

    abstract function getField(): string;
}
