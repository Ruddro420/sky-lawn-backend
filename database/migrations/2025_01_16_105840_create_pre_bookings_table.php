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
            $table->string('date_time')->nullable();
            $table->string('name')->nullable();
            $table->string('nationality')->nullable();
            $table->string('company')->nullable();
            $table->string('phone')->nullable();
            $table->string('person')->nullable();
            $table->string('room_category')->nullable();
            $table->string('room_number')->nullable();
            $table->string('room_price')->nullable();
            $table->string('duration_day')->nullable();
            $table->string('booking_by')->nullable();
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
