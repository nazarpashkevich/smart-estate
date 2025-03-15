<?php

namespace Database\Seeders;

use App\Domains\Estate\Models\EstateItem;
use App\Domains\User\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(1)->create();
        EstateItem::factory()->count(50)->create();
    }
}
