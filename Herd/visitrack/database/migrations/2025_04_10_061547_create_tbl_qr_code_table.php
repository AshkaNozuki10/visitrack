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
        Schema::create('tbl_qr_code', function (Blueprint $table) {
            $table->id('qr_id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('qr_text', 255)->nullable();
            $table->longText('qr_picture')->nullable();
        });
        /*
        //Foreign Key Constraint
        Schema::table('tbl_qr_code',  function(Blueprint $table){
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
        Schema::dropIfExists('tbl_qr_code');
    }
};
