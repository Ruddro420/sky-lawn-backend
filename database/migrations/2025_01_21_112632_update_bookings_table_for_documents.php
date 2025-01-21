<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBookingsTableForDocuments extends Migration
{
    public function up()
    {
        // Drop the existing columns if they already exist
        Schema::table('bookings', function (Blueprint $table) {
            // Drop columns if they exist
            $table->dropColumn(['nid_doc', 'couple_doc', 'passport_doc', 'visa_doc', 'other_doc']);
        });

        // Add new JSON columns for storing document paths
        Schema::table('bookings', function (Blueprint $table) {
            $table->json('nid_doc')->nullable();       // JSON column for nid documents
            $table->json('couple_doc')->nullable();    // JSON column for couple documents
            $table->json('passport_doc')->nullable();  // JSON column for passport documents
            $table->json('visa_doc')->nullable();      // JSON column for visa documents
            $table->json('other_doc')->nullable();     // JSON column for other documents
        });
    }

    public function down()
    {
        // Rollback the added columns if necessary
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['nid_doc', 'couple_doc', 'passport_doc', 'visa_doc', 'other_doc']);
        });
    }
}
