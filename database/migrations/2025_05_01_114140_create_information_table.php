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
        // create user table with foreign key 
        Schema::create('user', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('last_name');
            $table->string('first_name');   
            $table->string('middle_name')->nullable();
            $table->enum('sex', ['male', 'female']);
            $table->date('birthdate');
            $table->enum('role', ['admin', 'visitor'])->default('visitor');
            $table->timestamps();
        });

         // Finally create address with foreign key to user_information
         Schema::create('address', function (Blueprint $table) {
            $table->id('address_id');
            $table->unsignedBigInteger('user_id');
            $table->string('street_no');
            $table->string('street_name');  
            $table->string('barangay');
            $table->string('district')->nullable();
            $table->string('city');
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('user')
                  ->onDelete('cascade');
        });
        
        // create the credential table as it's independent
        Schema::create('credential', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->timestamps();
        });

        // Update credential table to add foreign key now that user_information exists
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
        Schema::dropIfExists('address');
        Schema::dropIfExists('user');
        Schema::dropIfExists('credential');
    }
};
