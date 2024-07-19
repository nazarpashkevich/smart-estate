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
        Schema::create('estate_items', function (Blueprint $table) {
            $table->id();
            $table->string('preview')->nullable();
            $table->text('description');
            $table->string('type');
            $table->tinyInteger('rooms')->unsigned()->index();
            $table->tinyInteger('floor')->unsigned()->index();
            $table->integer('year_of_build')->unsigned();
            $table->integer('square')->unsigned();
            $table->tinyInteger('bedrooms')->default(1)->unsigned();
            $table->boolean('has_parking')->default(false);
            $table->float('price')->unsigned();
            $table->float('lat')->nullable();
            $table->float('lng')->nullable();
            $table->json('features');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estate_items');
    }
};
