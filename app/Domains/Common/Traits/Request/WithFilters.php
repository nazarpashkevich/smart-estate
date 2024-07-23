<?php

namespace App\Domains\Common\Traits\Request;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait WithFilters
{

    public function filters(): ?Collection
    {
        return new Collection(Arr::whereNotNull($this->get('filters', [])));
    }

    protected function filtersRules(): array
    {
        return [
            'filters'   => ['array'],
            'filters.*' => [],
        ];
    }
}
