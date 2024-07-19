<?php

namespace Database\Factories;

use App\Domains\Location\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Location\Models\Location>
 */
class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition()
    {
        $street = $this->faker->streetAddress;
        $city = $this->faker->city;
        $country = $this->faker->country;
        $postcode = $this->faker->postcode;

        return [
            'lat'         => $this->faker->latitude,
            'lng'         => $this->faker->longitude,
            'name'        => $this->faker->numberBetween(1, 330) . ", $street, $city, $country $postcode",
            'postcode'    => $postcode,
            'county'      => $this->faker->state,
            'city'        => $city,
            'country'     => $country,
            'boundingbox' => [],
            'address'     => [
                'street'  => $street,
                'city'    => $city,
                'state'   => $this->faker->state,
                'country' => $country,
            ],
        ];
    }
}
