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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('room_number'); // Room Number
            $table->string('room_name'); // Room name
            $table->foreignId('room_category_id') // Room Category relation
                  ->constrained('room_categories') // Relates to 'id' column in 'room_categories'
                  ->onDelete('cascade'); // Cascade delete on related records
            $table->decimal('price', 10, 2); // Room price with precision
            $table->text('feature')->nullable(); // Room features, optional
            $table->timestamps(); // Created_at and Updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
