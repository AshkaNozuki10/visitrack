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
        Schema::create('tbl_approval', function (Blueprint $table) {
            $table->id('approval_id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->enum('status', ['Approved', 'Pending', 'Rejected']);
            $table->string('reason', 255);
            $table->date('date')->default(DB::raw('CURRENT_DATE'));
            $table->time('time')->default(DB::raw('CURRENT_TIME'));
        });

        /*
        //Foreign Key Constraints
        Schema::table('tbl_approval', function(Blueprint $table){
            $table->foreign('user_id')
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
        Schema::dropIfExists('tbl_approval');
    }
};
