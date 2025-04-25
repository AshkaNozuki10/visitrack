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
        Schema::create('tbl_location', function (Blueprint $table) {
            $table->id('location_id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('building_name', 55);
            $table->decimal('longitude', 9, 6);
            $table->decimal('latitude', 9, 6);
            $table->timestamp('timestamp');
        });
        /*
        //Foreign Key Constraints
        Schema::table('tbl_location',  function(Blueprint $table){
            $table->foregin('user_id')
                  ->references('user_id')
                  ->on('tbl_information')
                  ->onDelete('cascade');
        });
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_location');
    }
};
