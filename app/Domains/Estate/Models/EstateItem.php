<?php

namespace App\Domains\Estate\Models;

use App\Domains\Estate\Enums\EstateItemType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int                                      $id
 * @property string                                   $preview
 * @property string                                   $description
 * @property int                                      $rooms
 * @property int                                      $floor
 * @property \App\Domains\Estate\Enums\EstateItemType $type
 * @property int                                      $year_of_build
 * @property float                                    $square
 * @property int                                      $bedrooms
 * @property bool                                     $hasParking
 * @property float                                    $lat
 * @property float                                    $lng
 * @property float                                    $price
 * @property string[]                                 $features
 */
class EstateItem extends Model
{
    protected $guarded = [];

    protected $casts = [
        'type'       => EstateItemType::class,
        'hasParking' => 'bool',
        'features'   => 'json',
    ];

    public function toArray(): array
    {
        $item = parent::toArray();

        return array_combine(array_map([Str::class, 'camel'], array_keys($item)), array_values($item));
    }
}
