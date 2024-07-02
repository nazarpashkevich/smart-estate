<?php

namespace App\Domains\Search\Contracts;

interface ElasticSearchFilterable
{
    public function elasticField(): string;

    public function elasticFilter(): array;

    public function isFilter(): bool;
}
