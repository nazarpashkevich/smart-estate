<?php

namespace App\Domains\Estate\Models;

use Akaunting\Money\Money;
use App\Domains\Common\Casts\MoneyCast;
use App\Domains\Common\Traits\Model\Arrayable;
use App\Domains\Common\Traits\Model\InteractWithBuilder;
use App\Domains\Common\Traits\Model\InteractWithFilter;
use App\Domains\Estate\Builders\EstateItemBuilder;
use App\Domains\Estate\Enums\EstateItemFilter;
use App\Domains\Estate\Enums\EstateItemType;
use App\Domains\Location\Models\Location;
use App\Domains\Search\Contracts\Model\ElasticSearchable;
use App\Domains\Search\Traits\Model\Searchable;
use Database\Factories\EstateItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @property Money                                    $price
 * @property string[]                                 $features
 *
 * @property \App\Domains\Location\Models\Location    $location
 *
 * @method static \App\Domains\Estate\Builders\EstateItemBuilder query()
 */
class EstateItem extends Model implements ElasticSearchable
{
    use Arrayable;
    use Searchable;
    use InteractWithBuilder;
    use InteractWithFilter;
    use HasFactory;


    public string $customBuilder = EstateItemBuilder::class;
    public string $customFilter = EstateItemFilter::class;
    protected $perPage = 5;
    protected $guarded = [];

    protected $casts = [
        'type'        => EstateItemType::class,
        'has_parking' => 'bool',
        'features'    => 'json',
        'price'       => MoneyCast::class,
    ];

    protected static function newFactory(): EstateItemFactory|\Illuminate\Database\Eloquent\Factories\Factory
    {
        return EstateItemFactory::new();
    }

    protected static function boot(): void
    {
        parent::boot();
        static::bootSearchable();
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function toElasticsearchDocumentArray(): array
    {
        $this->loadMissing('location');

        return [
            'description'   => $this->description,
            'rooms'         => $this->rooms,
            'floor'         => $this->floor,
            'year_of_build' => $this->year_of_build,
            'location'      => [
                'name'     => $this->location->name,
                'postcode' => $this->location->postcode,
            ],
        ];
    }

    public function toVectorStoreArray(): array
    {
        $this->loadMissing('location');

        return [
            'property_id'   => $this->id,
            'description'   => $this->description,
            'type'          => $this->type->value,
            'rooms'         => $this->rooms,
            'floor'         => $this->floor,
            'year_of_build' => $this->year_of_build,
            'square'        => $this->square,
            'bedrooms'      => $this->bedrooms,
            'price'         => [
                'value'    => $this->price->getValue(),
                'currency' => $this->price->getCurrency()->getCurrency(),
            ],
            'features'      => $this->features,
            'location'      => [
                'name'     => $this->location->name,
                'city'     => $this->location->city,
                'county'   => $this->location->county,
                'postcode' => $this->location->postcode,
            ],
        ];
    }
}
