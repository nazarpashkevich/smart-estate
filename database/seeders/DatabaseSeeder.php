<?php

namespace Database\Seeders;

use App\Domains\Estate\Models\EstateItem;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        EstateItem::factory()->count(20)->create();
    }
}
