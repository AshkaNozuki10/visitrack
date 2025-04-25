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
        Schema::create('tbl_address', function (Blueprint $table) {
            $table->id('address_id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('street_no', 55);
            $table->string('street_name', 55);
            $table->string('barangay', 55);
            $table->string('district', 55)->nullable();
            $table->string('city', 55);
        });

        /*
         //Foreign Key Constraints
         Schema::table('tbl_address',  function(Blueprint $table){
            $table->foreign('user_id')
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
        Schema::dropIfExists('tbl_address');
    }
};
