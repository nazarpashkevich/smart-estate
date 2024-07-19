<?php

namespace Database\Factories;

use App\Domains\Estate\Enums\EstateItemType;
use App\Domains\Estate\Models\EstateItem;
use App\Domains\Location\Models\Location;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Estate\Models\EstateItem>
 */
class EstateItemFactory extends Factory
{
    protected $model = EstateItem::class;

    public function definition()
    {
        $randomImageUrl = 'https://picsum.photos/640/480';
        $fileName = Str::random(10) . '.jpg';

        // download and save random image
        $client = new Client();
        $response = $client->get($randomImageUrl);

        // save locally
        Storage::put('public/uploads/' . $fileName, $response->getBody());

        return [
            'preview'       => Storage::url('uploads/' . $fileName), // public path
            'description'   => $this->faker->paragraph,
            'type'          => $this->faker->randomElement(EstateItemType::cases()),
            'rooms'         => $this->faker->numberBetween(1, 5),
            'floor'         => $this->faker->numberBetween(1, 10),
            'year_of_build' => $this->faker->year,
            'square'        => $this->faker->numberBetween(30, 300),
            'bedrooms'      => $this->faker->numberBetween(1, 5),
            'has_parking'   => $this->faker->boolean,
            'price'         => $this->faker->randomFloat(2, 50000, 1000000),
            'features'      => $this->faker->randomElements(['pool', 'garden', 'garage'], 2),
            'location_id'   => Location::factory(),
            'user_id'       => 1,
        ];
    }
}
