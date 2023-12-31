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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id');
            $table->foreignId('user_id');
            $table->string('payment_process');
            $table->string('status');
            $table->date('checkin');
            $table->date('checkout');
            $table->integer('days');
            $table->integer('discount')->nullable();
            $table->string('payment_screenshot')->nullable();
            $table->integer('total');
            $table->integer('guests');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
