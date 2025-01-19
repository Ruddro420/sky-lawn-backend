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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('fathers_name')->nullable();
            $table->string('mothers_name')->nullable();
            $table->string('address')->nullable();
            $table->string('nationality')->nullable();
            $table->string('profession')->nullable();
            $table->string('company')->nullable();
            $table->string('comming_form')->nullable();
            $table->string('purpose')->nullable();
            $table->string('checking_date_time')->nullable();
            $table->string('checkout_date_time')->nullable();
            $table->string('room_category')->nullable();
            $table->string('room_number')->nullable();
            $table->string('room_price')->nullable();
            $table->string('person')->nullable();
            $table->string('duration_day')->nullable();
            $table->string('total_price')->nullable();
            $table->string('nid_no')->nullable();
            $table->string('nid_doc')->nullable();
            $table->string('couple_doc')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('passport_doc')->nullable();
            $table->string('visa_no')->nullable();
            $table->string('visa_doc')->nullable();
            $table->string('other_doc')->nullable();
            $table->string('advance')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('check_status')->nullable()->default(0);
            $table->string('status')->nullable()->default(0);
            $table->string('invoice')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
