<?php

namespace App\Domains\Estate\Models;

use App\Domains\Common\Casts\MoneyCast;
use App\Domains\Common\Traits\Model\Arrayable;
use App\Domains\Common\Traits\Model\InteractWithBuilder;
use App\Domains\Common\Traits\Model\InteractWithFilter;
use App\Domains\Estate\Builders\EstateItemBuilder;
use App\Domains\Estate\Enums\EstateItemFilter;
use App\Domains\Estate\Enums\EstateItemType;
use App\Domains\Location\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property bool                                     $has_parking
 * @property float                                    $lat
 * @property float                                    $lng
 * @property float                                    $price
 * @property string[]                                 $features
 */
class EstateItem extends Model
{
    use Arrayable;
    use InteractWithBuilder;
    use InteractWithFilter;

    public string $customBuilder = EstateItemBuilder::class;
    public string $customFilter = EstateItemFilter::class;

    protected $guarded = [];

    protected $casts = [
        'type'        => EstateItemType::class,
        'has_parking' => 'bool',
        'features'    => 'json',
        'price'       => MoneyCast::class,
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
