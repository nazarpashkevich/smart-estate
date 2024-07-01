<?php

namespace App\Domains\Estate\Models;

use App\Domains\Common\Traits\Model\InteractWithBuilder;
use App\Domains\Common\Traits\Model\InteractWithFilter;
use App\Domains\Estate\Builders\EstateItemBuilder;
use App\Domains\Estate\Enums\EstateItemFilter;
use App\Domains\Estate\Enums\EstateItemType;
use App\Domains\Location\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    use InteractWithBuilder;
    use InteractWithFilter;

    public string $customBuilder = EstateItemBuilder::class;
    public string $customFilter = EstateItemFilter::class;

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

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
