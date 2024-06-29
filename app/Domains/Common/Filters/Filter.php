<?php

namespace App\Domains\Common\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    public function __construct(protected mixed $value)
    {
        $this->resolveValue($this->value);
    }

    public function handle(Builder $query, \Closure $next): Builder
    {
        return $next($this->filter($query));
    }

    abstract public function filter(Builder $query): Builder;

    public function resolveValue(mixed $value): void
    {
    }
}
