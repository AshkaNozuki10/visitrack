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
        Schema::table('tbl_information', function (Blueprint $table) {
            $table->foreign('address')
            ->references('address_id')
            ->on('tbl_address')
            ->onDelete('cascade');

            $table->foreign('credential')
            ->references('credential_id')
            ->on('tbl_credential')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_information', function (Blueprint $table) {
            $table->dropForeign(['address']);
            $table->dropForeign(['credential']);
        });
    }
};
