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
        Schema::create('pre_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('date_time');
            $table->string('name');
            $table->string('nationality');
            $table->string('company')->nullable();
            $table->string('phone');
            $table->string('person');
            $table->string('room_category');
            $table->string('room_number');
            $table->string('room_price');
            $table->string('duration_day');
            $table->string('booking_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_bookings');
    }
};
