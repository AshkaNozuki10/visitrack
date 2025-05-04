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
        Schema::create('appointment', function (Blueprint $table) {
            $table->id('appointment_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('user_information');
            $table->integer('visit_id');
            $table->foreign('visit_id')->references('visit_id')->on('visit');
            $table->date('visit_date');
            $table->time('visit_time');
            $table->integer('approval');
            $table->unsignedBigInteger('qr_code');
            $table->foreign('qr_code')->references('qr_id')->on('qr_code');

            $table->timestamps();
        });

        Schema::create('qr_code', function (Blueprint $table){
            $table->id('qr_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('user_information');
            $table->string('qr_text');
            $table->binary('qr_image');
        });

        Schema::create('approval', function (Blueprint $table){
            $table->id('approval_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('user_information');
            $table->enum('status', ['approved', 'rejected', 'pending']);
            $table->string('reason');

            $table->timestamps();
        });

        Schema::create('visit', function (Blueprint $table){
            $table->id('visit_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('user_information');
            $table->date('visit_date');
            $table->time('entry_time');
            $table->time('exit_time');
            $table->unsignedBigInteger('location');
            $table->foreign('location')->references('location_id')->on('location');
        });

        Schema::create('location', function (Blueprint $table){
            $table->id('location_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('user_information');
            $table->string('building_name');
            $table->decimal('latitude', 9, 6);
            $table->decimal('longitude', 9, 6);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment');
        Schema::dropIfExists('qr_code');
        Schema::dropIfExists('visit');
        Schema::dropIfExists('approval');
        Schema::dropIfExists('location');
    }
};
