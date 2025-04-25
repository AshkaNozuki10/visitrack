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
    public function up(): void
    {
        Schema::create('tbl_visit', function (Blueprint $table){
            $table->id('visit_id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->date('visit_date')->default(DB::raw('CURRENT_DATE'));
            $table->time('entry_time')->default(DB::raw('CURRENT_TIME'));
            $table->time('exit_time')->default(DB::raw('CURRENT_TIME'));
            $table->unsignedBigInteger('location');
        });
            /*
            //Foreign Key Constraints
            Schema::table('tbl_visit', function(Blueprint $table){
                $table->foreign('user_id')
                      ->references('user_id')
                      ->on('tbl_information')
                      ->onDelete('cascade');

                $table->foreign('location')
                      ->references('location_id')
                      ->on('tbl_location')
                      ->onDelete('cascade');
        });
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_visit');
    }
};
