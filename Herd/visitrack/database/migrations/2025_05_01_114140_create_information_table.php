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
        Schema::create('user_information', function (Blueprint $table) {

            // this line throw QueryException "SQLSTATE[HY000]: General error: 1215 Cannot add foreign key constraint..."
            // $table->integer('user_id')->unsigned()->index();
            $table->id('user_id')
                    ->unsigner()
                    ->index();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')
                    ->nullable();
            $table->enum('sex', ['male', 'female']);
            $table->date('birthdate');
            $table->enum('role', ['student', 'non_student', 'admin', 'faculty', 'contractor']);

            $table->timestamps();
        });

        Schema::create('address', function (Blueprint $table) {
            // this line throw QueryException "SQLSTATE[HY000]: General error: 1215 Cannot add foreign key constraint..."
            // $table->integer('user_id')->unsigned()->index();
            $table->id('address_id');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')
                    ->references('user_id')
                    ->on('user_information')
                    ->onDelete('cascade');
            $table->string('street_no');
            $table->string('street_name');  
            $table->string('barangay');
            $table->string('district')
                    ->nullable();
            $table->string('city');

            $table->timestamps();
        });

        Schema::create('credential', function (Blueprint $table) {
            $table->id('credential_id');
            $table->unsignedBigInteger('user_id')
                    ->index();
            $table->foreign('user_id')
                    ->references('user_id')
                    ->on('user_information')
                    ->onDelete('cascade');
            $table->string('username');
            $table->string('password');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_information');
        Schema::dropIfExists('address');
        Schema::dropIfExists('credential');
    }
};
