<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
        public function up(): void{
        // Create independent tables first
        Schema::create('location', function (Blueprint $table) {
            $table->id('location_id');
            $table->unsignedBigInteger('user_id')->nullable(); // Make user_id nullable since it's not always needed
            $table->string('building_name');
            $table->decimal('latitude', 9, 6);
            $table->decimal('longitude', 9, 6);
        });

        // Seed the location table with building data
        DB::table('location')->insert([
            [
                'building_name' => 'New Academic Building',
                'latitude' => 14.70120141404739,
                'longitude' => 121.03268300148409
            ],
            [
                'building_name' => 'Gymnasium',
                'latitude' => 14.700469562813325,
                'longitude' => 121.03357528078936
            ],
            [
                'building_name' => 'Administration Building',
                'latitude' => 14.700598681117,
                'longitude' => 121.03275394865807
            ],
            [
                'building_name' => 'IK Building',
                'latitude' => 14.70082344049655,
                'longitude' => 121.03226347431922
            ],
            [
                'building_name' => 'CHED Building',
                'latitude' => 14.700088050486443,
                'longitude' => 121.03313580065276
            ],
            [
                'building_name' => 'KORPHIL Building',
                'latitude' => 14.69999928141543,
                'longitude' => 121.03121723653908
            ],
            [
                'building_name' => 'QCU Urban Farm Zone',
                'latitude' => 14.70093172051935,
                'longitude' => 121.0318334776943
            ],
            [
                'building_name' => 'Quezon City Quarantine Zone',
                'latitude' => 14.700354438139726,
                'longitude' => 121.03125266069407
            ],
            [
                'building_name' => 'QCU Entrep Zone',
                'latitude' => 14.70069991543923,
                'longitude' => 121.033772752005
            ],
            [
                'building_name' => 'Belmonte Building',
                'latitude' => 14.701018650021524,
                'longitude' => 121.03303994441052
            ]
        ]);

        Schema::create('visit', function (Blueprint $table){
            $table->id('visit_id');
            $table->unsignedBigInteger('user_id');
            $table->date('visit_date');
            $table->time('entry_time');
            $table->time('exit_time');
            $table->unsignedBigInteger('location');
        });

        Schema::create('qr_code', function (Blueprint $table){
            $table->id('qr_id');
            $table->unsignedBigInteger('user_id');
            $table->string('qr_text');
            $table->binary('qr_image');
        });

        // Then create dependent tables
        Schema::create('appointment', function (Blueprint $table) {
            $table->id('appointment_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('visit_id'); // Changed from integer
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->integer('approval')->nullable();
            $table->unsignedBigInteger('qr_code')->nullable();
            $table->timestamps();

        // Add foreign keys after all tables exist
        $table->foreign('user_id')->references('user_id')->on('user');
        $table->foreign('visit_id')->references('visit_id')->on('visit');
        $table->foreign('qr_code')->references('qr_id')->on('qr_code');
        });

        // Add foreign keys to previously created tables
        Schema::table('visit', function (Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('user');
            $table->foreign('location')->references('location_id')->on('location');
        });

        Schema::table('qr_code', function (Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('user');
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
