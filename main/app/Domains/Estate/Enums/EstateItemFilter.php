<?php

namespace App\Domains\Estate\Enums;

use App\Domains\Common\Filters\Filter;
use App\Domains\Estate\Filters\EstateItem\BedroomsFilter;
use App\Domains\Estate\Filters\EstateItem\PriceFromFilter;
use App\Domains\Estate\Filters\EstateItem\PriceToFilter;
use App\Domains\Estate\Filters\EstateItem\RoomsFilter;
use App\Domains\Estate\Filters\EstateItem\SearchFilter;
use App\Domains\Estate\Filters\EstateItem\UserFilter;
use App\Domains\Estate\Filters\EstateItem\YearOfBuildFilter;

enum EstateItemFilter: string
{
    case PriceFrom = 'priceFrom';
    case PriceTo = 'priceTo';
    case Rooms = 'rooms';
    case Bedrooms = 'bedrooms';
    case YearOfBuild = 'yearOfBuild';
    case Search = 'search';
    case User = 'user';

    public function createFilter(mixed $value): Filter
    {
        return match ($this) {
            self::PriceFrom   => new PriceFromFilter($value),
            self::PriceTo     => new PriceToFilter($value),
            self::Rooms       => new RoomsFilter($value),
            self::Bedrooms    => new BedroomsFilter($value),
            self::YearOfBuild => new YearOfBuildFilter($value),
            self::Search      => new SearchFilter($value),
            self::User        => new UserFilter($value),
        };
    }
}
