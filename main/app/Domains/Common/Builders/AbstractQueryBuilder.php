<?php

namespace App\Domains\Common\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class AbstractQueryBuilder extends Builder
{
    public function filter(?Collection $filters = null): self
    {
        if ($filters->count()) {
            $filters = $this->resolveFilters($filters);

            app(Pipeline::class)
                ->send($this)
                ->through($filters)
                ->thenReturn();
        }

        return $this;
    }

    public function resolveFilters(?Collection $filters = null): array
    {
        return Arr::whereNotNull($filters->map(
            fn (mixed $value, mixed $name) => static::getModel()->getFilter()::tryFrom($name)?->createFilter($value)
        )->values()->toArray());
    }
}
