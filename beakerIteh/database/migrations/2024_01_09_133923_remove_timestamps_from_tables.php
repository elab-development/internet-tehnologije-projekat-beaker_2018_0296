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
        Schema::table('users', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        // Remove timestamps from the 'reservations' table
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        // Remove timestamps from the 'vehicles' table
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamps();
        });

        // Add timestamps back to the 'reservations' table
        Schema::table('reservations', function (Blueprint $table) {
            $table->timestamps();
        });

        // Add timestamps back to the 'vehicles' table
        Schema::table('vehicles', function (Blueprint $table) {
            $table->timestamps();
        });
    }
};
