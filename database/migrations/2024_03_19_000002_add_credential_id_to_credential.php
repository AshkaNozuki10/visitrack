<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, create a temporary table with the new structure
        Schema::create('credential_new', function (Blueprint $table) {
            $table->id('credential_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Copy data from the old table to the new one
        DB::statement('INSERT INTO credential_new (user_id, username, password, created_at, updated_at) 
                      SELECT user_id, username, password, created_at, updated_at FROM credential');

        // Drop the old table
        Schema::drop('credential');

        // Rename the new table to the original name
        Schema::rename('credential_new', 'credential');

        // Add the foreign key constraint
        Schema::table('credential', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('user')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Create a temporary table with the old structure
        Schema::create('credential_old', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Copy data from the new table to the old one
        DB::statement('INSERT INTO credential_old (user_id, username, password, created_at, updated_at) 
                      SELECT user_id, username, password, created_at, updated_at FROM credential');

        // Drop the new table
        Schema::drop('credential');

        // Rename the old table back to the original name
        Schema::rename('credential_old', 'credential');

        // Add the foreign key constraint
        Schema::table('credential', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('user')
                  ->onDelete('cascade');
        });
    }
}; 