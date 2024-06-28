<?php

namespace App\Domains\Estate\Data;

use App\Domains\Common\Data\BaseData;
use App\Domains\Estate\Enums\EstateItemType;
use App\Domains\Estate\Models\EstateItem;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;

class EstateItemData extends BaseData
{
    public function __construct(
        public string $preview,
        public string $description,
        #[WithCast(EnumCast::class)]
        public EstateItemType $type,
        public int $yearOfBuild,
        public float $square,
        public float $price,
        public ?float $lat = null,
        public ?float $lng = null,
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
            'preview'       => $this->preview,
            'description'   => $this->description,
            'type'          => $this->type,
            'year_of_build' => $this->yearOfBuild,
            'square'        => $this->square,
            'price'         => $this->price,
            'lat'           => $this->lat,
            'lng'           => $this->lng,
            'rooms'         => $this->rooms,
            'floor'         => $this->floor,
            'bedrooms'      => $this->bedrooms,
            'has_parking'   => $this->hasParking,
            'features'      => $this->features,
        ]);

        return $estateItem;
    }

}