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
        Schema::create('tbl_appointment', function (Blueprint $table) {
            $table->id('appointment_id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->unsignedBigInteger('visit_id')->unique();
            $table->date('visit_date');
            $table->time('visit_time');
            $table->foreignId('approval');
            $table->date('created_date')->default(DB::raw('CURRENT_DATE'));
            $table->timestamp('created_time')->useCurrent();
            $table->unsignedBigInteger('qr_code')->unique();
        });

        /*
        //Foreign Key Constraints
        Schema::table('tbl_appointment', function (Blueprint $table){
            $table->foreign('user_id') //Column that need to  contraint
                  ->references('user_id') //Column from the other table that need to constraint
                  ->on('tbl_information') //Table that has relationship to this table
                  ->onDelete('cascade'); //Action on whether to delete or update

            $table->foreign('qr_code')
                  ->references('qr_id')
                  ->on('tbl_qr_code')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_appointment');
    }
};
