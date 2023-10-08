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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id');
            $table->string('title');
            $table->string('description');
            $table->string('price');
            $table->string('location');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('guests');
            $table->integer('rooms');
            $table->integer('bathrooms');
            $table->integer('beds');
            $table->json('amenities');
            $table->json('images');
            $table->string('status');
            $table->decimal('monthly_discount', 8, 2)->nullable();
            $table->string('bldg_permit')->nullable();
            $table->timestamps();
            
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
