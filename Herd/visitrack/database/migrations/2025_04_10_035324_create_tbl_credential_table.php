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
        Schema::create('tbl_credential', function (Blueprint $table) {
            $table->id('credential_id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('username', 255);
            $table->string('password', 255);
        });

        //Foreign Key Constraints
        Schema::table('tbl_credential',  function(Blueprint $table){
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('tbl_information')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_credential');
    }
};
