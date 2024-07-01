<?php

namespace App\Domains\Estate\Enums;

use App\Domains\Common\Filters\Filter;
use App\Domains\Estate\Filters\EstateItem\BedroomsFilter;
use App\Domains\Estate\Filters\EstateItem\PriceFromFilter;
use App\Domains\Estate\Filters\EstateItem\PriceToFilter;
use App\Domains\Estate\Filters\EstateItem\RoomsFilter;
use App\Domains\Estate\Filters\EstateItem\YearOfBuildFilter;
use App\Domains\Estate\Filters\PriceFilter;
use App\Domains\Recipe\Filters\Recipe\AllergyFilter;
use App\Domains\Recipe\Filters\Recipe\CategoryFilter;
use App\Domains\Recipe\Filters\Recipe\CuisineFilter;
use App\Domains\Recipe\Filters\Recipe\DietFilter;
use App\Domains\Recipe\Filters\Recipe\MealTypeFilter;
use App\Domains\Recipe\Filters\Recipe\SearchFilter;

enum EstateItemFilter: string
{
    case PriceFrom = 'priceFrom';
    case PriceTo = 'priceTo';
    case Rooms = 'rooms';
    case Bedrooms = 'bedrooms';
    case YearOfBuild = 'yearOfBuild';

    public function createFilter(mixed $value): Filter
    {
        return match ($this) {
            self::PriceFrom   => new PriceFromFilter($value),
            self::PriceTo     => new PriceToFilter($value),
            self::Rooms       => new RoomsFilter($value),
            self::Bedrooms    => new BedroomsFilter($value),
            self::YearOfBuild => new YearOfBuildFilter($value),
        };
    }
}
