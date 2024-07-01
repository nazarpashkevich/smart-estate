<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->float('lat');
            $table->float('lng');
            $table->string('name');
            $table->string('postcode');
            $table->string('county')->default('');
            $table->string('city')->default('');
            $table->string('country');
            $table->json('boundingbox');
            $table->json('address');
            $table->timestamps();
        });

        Schema::table('estate_items', function (Blueprint $table) {
            $table->foreignIdFor(\App\Domains\Location\Models\Location::class);
            $table->dropColumn('lat', 'lng');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
