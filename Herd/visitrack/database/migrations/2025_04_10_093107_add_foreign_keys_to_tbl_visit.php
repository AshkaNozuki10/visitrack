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
        Schema::table('tbl_visit', function (Blueprint $table) {
            $table->foreign('user_id')
            ->references('user_id')
            ->on('tbl_information')
            ->onDelete('cascade');

            $table->foreign('location')
            ->references('location_id')
            ->on('tbl_location')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_visit', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['location_id']);
        });
    }
};
