<?php

namespace App\Domains\Estate\Data;

use Akaunting\Money\Money;
use App\Domains\Common\Data\BaseData;
use App\Domains\Common\Data\Casts\PriceCast;
use App\Domains\Common\Data\Transformers\PriceTransformer;
use App\Domains\Estate\Enums\EstateItemType;
use App\Domains\Estate\Models\EstateItem;
use App\Domains\Location\Data\LocationData;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\EnumCast;

class EstateItemData extends BaseData
{
    public function __construct(
        public string $description,
        #[WithCast(EnumCast::class)]
        public EstateItemType $type,
        public int $yearOfBuild,
        public float $square,
        #[WithTransformer(PriceTransformer::class)]
        #[WithCast(PriceCast::class)]
        public Money $price,
        public LocationData $location,
        public ?string $preview = null,
        public int $rooms = 1,
        public int $floor = 1,
        public int $bedrooms = 1,
        public bool $hasParking = false,
        public array $features = [],
        public ?int $id = null,
    ) {
    }

    public function toModel(int|EstateItem|null $estateItem = null): EstateItem
    {
        if (is_int($estateItem)) {
            $estateItem = EstateItem::query()->findOrFail($estateItem);
        }

        $estateItem ??= new EstateItem();
        $estateItem->fill([
            'preview'       => $this->preview ?? $estateItem->preview,
            'description'   => $this->description,
            'type'          => $this->type,
            'year_of_build' => $this->yearOfBuild,
            'square'        => $this->square,
            'price'         => $this->price,
            'rooms'         => $this->rooms,
            'floor'         => $this->floor,
            'bedrooms'      => $this->bedrooms,
            'has_parking'   => $this->hasParking,
            'features'      => $this->features,
            'location_id'   => $this->location->toModel()->id,
        ]);


        return $estateItem;
    }

    // append properties to resource
    public function with(): array
    {
        return [
            'title'           => $this->location?->name,
            'price_formatted' => $this->price->format(),
        ];
    }
}
