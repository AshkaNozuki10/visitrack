<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
        public function up(): void{
        // Create independent tables first
        Schema::create('location', function (Blueprint $table) {
            $table->id('location_id');
            $table->unsignedBigInteger('user_id');
            $table->string('building_name');
            $table->decimal('latitude', 9, 6);
            $table->decimal('longitude', 9, 6);
        });

        Schema::create('visit', function (Blueprint $table){
            $table->id('visit_id');
            $table->unsignedBigInteger('user_id');
            $table->date('visit_date');
            $table->time('entry_time');
            $table->time('exit_time');
            $table->unsignedBigInteger('location');

            $table->timestamps();
        });

        Schema::create('qr_code', function (Blueprint $table){
            $table->id('qr_id');
            $table->unsignedBigInteger('user_id');
            $table->string('qr_text');
            $table->binary('qr_image');

            $table->timestamps();
        });

        // Then create dependent tables
        Schema::create('appointment', function (Blueprint $table) {
            $table->id('appointment_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('visit_id'); // Changed from integer
            $table->enum('type', ['Walk In', 'Appointment']);
            $table->text('transaction_type');
            $table->text('purpose_of_visit');
            $table->enum('department_type', ['CCS Department', 
                                        'Education Department', 
                                        'Accounting Department',
                                        'Entrepreneurship Department', 
                                        'Engineering Department']);
            $table->enum('building', ['Gymnasium',
                                    'Administration Building',
                                    'QCU Urban Farm Zone',
                                    'Korphil Building',
                                    'CHED Building',
                                    'QCU Entrep Zone',
                                    'Belmonte Building',
                                    'New Academiz Building',
                                    'Quarantine Zone',
                                    'Auditorium Building']);
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
