<?php

namespace App\Domains\Search\Traits\Filter;

trait ElasticSearchFilter
{
    public function elasticFilter(): array
    {
        return [
            'term' => [
                $this->elasticField() => $this->value,
            ],
        ];
    }

    public function isFilter(): bool
    {
        return true;
    }
}
