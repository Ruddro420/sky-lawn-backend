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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->nullable();
            $table->string('booking_id')->nullable();
            $table->string('name')->nullable();
            $table->string('profession')->nullable();
            $table->string('company')->nullable();
            $table->string('mobile')->nullable();
            $table->string('checking_date_time')->nullable();
            $table->string('checkout_date_time')->nullable();
            $table->string('room_type')->nullable();
            $table->string('person')->nullable();
            $table->string('comming_from')->nullable();
            $table->string('room_price')->nullable();
            $table->string('duration')->nullable();
            $table->string('total_price')->nullable();
            $table->string('advance')->nullable();
            $table->string('discount')->nullable();
            $table->string('final_amount')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('extra-1')->nullable();
            $table->string('extra-2')->nullable();
            $table->string('extra-3')->nullable();
            $table->string('extra-4')->nullable();
            $table->string('extra-5')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
