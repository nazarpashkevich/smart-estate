<?php

namespace App\Domains\Estate\Enums;

use App\Domains\Common\Filters\Filter;
use App\Domains\Estate\Filters\EstateApplication\StatusFilter;
use App\Domains\Estate\Filters\PriceFilter;
use App\Domains\Recipe\Filters\Recipe\AllergyFilter;
use App\Domains\Recipe\Filters\Recipe\CategoryFilter;
use App\Domains\Recipe\Filters\Recipe\CuisineFilter;
use App\Domains\Recipe\Filters\Recipe\DietFilter;
use App\Domains\Recipe\Filters\Recipe\MealTypeFilter;
use App\Domains\Recipe\Filters\Recipe\SearchFilter;

enum EstateApplicationFilter: string
{
    case Status = 'status';

    public function createFilter(mixed $value): Filter
    {
        return match ($this) {
            self::Status => new StatusFilter($value),
        };
    }
}
