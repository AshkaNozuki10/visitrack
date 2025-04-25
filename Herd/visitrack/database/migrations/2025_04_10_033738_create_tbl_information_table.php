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
        Schema::create('tbl_information', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('last_name', 55);
            $table->string('first_name', 55);
            $table->string('middle_name', 55)->nullable();
            $table->enum('sex', ['male', 'female']);
            $table->date('birth_date');
            $table->unsignedBigInteger('address');
            $table->unsignedBigInteger('credential');
            $table->enum('role', ['Student', 'Admin', 'Faculty', 'Contractor', 'Vendor']);
        });

        /*
        //Foreign Key Constraints
        Schema::table('tbl_information', function(Blueprint $table){
            $table->foreign('address')
                  ->references('address_id')
                  ->on('tbl_address')
                  ->onDelete('cascade');

            $table->foreign('credential')
                  ->references('credential_id')
                  ->on('tbl_credential')
                  ->onDelete('cascade');
        });
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
