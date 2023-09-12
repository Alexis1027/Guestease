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
        Schema::create('guest_houses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id');
            // $table->string('room_name');
            $table->string('title');
            // $table->string('room_details');
            $table->string('description');
            // $table->string('room_price');
            $table->string('price');
            // $table->string('room_location');
            $table->string('location');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('guests');
            $table->integer('rooms');
            $table->integer('bathrooms');
            $table->integer('beds');
            $table->json('amenities');
            // $table->text('room_image');
            $table->text('images');
            $table->timestamps();
            // location: '',
            // latitude: null,
            // longitude: null,
            // guests: 1,
            // rooms: 1,
            // bathrooms: 0,
            // beds: 1,
            // amenities: [],
            // title: '',
            // description: '',
            // price: 2500
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_houses');
    }
};
