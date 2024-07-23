<?php

namespace App\Domains\Common\Values;

use Illuminate\Database\Eloquent\Builder;

class SortValue
{
    protected function __construct(protected $field, protected $direction)
    {
    }

    public static function make(string $field, string $direction = 'asc'): SortValue
    {
        return new self($field, $direction);
    }

    public function applyTo(Builder $query): Builder
    {
        return $query->orderBy($this->field, $this->direction);
    }

}
