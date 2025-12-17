<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('district_coordinates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zone_id');
            $table->text('zone_coordinates');
            $table->unsignedBigInteger('zonemapshape'); 
            $table->unsignedBigInteger('district_id');
            $table->timestamps();

            $table->foreign('zone_id')->references('id')->on('district_zone')->onDelete('cascade');
            $table->foreign('zonemapshape')->references('id')->on('map_shapes')->onDelete('cascade'); // adjust table name
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('district_coordinates');
    }
};
