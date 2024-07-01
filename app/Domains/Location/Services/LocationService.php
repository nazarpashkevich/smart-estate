<?php

namespace App\Domains\Location\Services;

use App\Domains\Location\Data\LocationData;
use App\Domains\Location\Models\Location;

class LocationService
{

    public function __construct(protected GeoCodeService $geoCodeService)
    {
    }

    public function make(LocationData $data): Location
    {
        return Location::query()
            ->where('lat', $data->lat)
            ->where('lng', $data->lng)
            ->firstOr(fn () => $this->create($data));
    }

    public function create(LocationData $data): Location
    {
        $data = $this->geoCodeService->findByCoords($data->lat, $data->lng);

        $location = new Location();

        $location->fill([
            'lat'         => $data->lat,
            'lng'         => $data->lng,
            'name'        => $data->display_name,
            'postcode'    => $data->address?->postcode,
            'county'      => $data->address?->county,
            'country'     => $data->address?->country,
            'city'        => $data->address?->city ?? $data->address?->village,
            'boundingbox' => $data->boundingbox,
            'address'     => $data->address,
        ]);

        $location->save();

        return $location;
    }
}
