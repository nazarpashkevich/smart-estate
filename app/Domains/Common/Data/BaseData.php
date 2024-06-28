<?php

namespace App\Domains\Common\Data;

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\PaginatedDataCollection;

abstract class BaseData extends Data
{
    public static function toWrap(LengthAwarePaginator $items): PaginatedDataCollection
    {
        return static::collect($items, PaginatedDataCollection::class)->wrap('data');
    }
}
