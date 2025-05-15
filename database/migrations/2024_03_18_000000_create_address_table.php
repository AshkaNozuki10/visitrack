<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('address', function (Blueprint $table) {
            $table->id('address_id');
            $table->unsignedBigInteger('user_id');
            $table->string('street_no', 20);
            $table->string('street_name', 100);
            $table->string('barangay', 100);
            $table->string('district', 100);
            $table->string('city', 100);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('user')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('address');
    }
}; 