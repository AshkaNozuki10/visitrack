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
         Schema::table('user', function (Blueprint $table) {
            DB::statement("ALTER TABLE user MODIFY COLUMN role ENUM('visitor', 'admin', 'guard')");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            DB::statement("ALTER TABLE user MODIFY COLUMN role ENUM('visitor', 'admin')");
        });
    }
};
