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
        Schema::table('user', function (Blueprint $table) {
            $table->boolean('is_blacklisted')->default(false);
            $table->text('blacklist_reason')->nullable();
        });

        Schema::table('appointment', function(Blueprint $table){
            $table->string('purpose')->nullable();
            $table->string('department')->nullable();
        });

        // Create activity_logs table
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->text('description');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('user_information')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('user', function (Blueprint $table) {
            $table->dropColumn(['is_blacklisted', 'blacklist_reason']);
        });

        Schema::table('appointment', function (Blueprint $table) {
            $table->dropColumn(['purpose', 'department']);
        });

        Schema::dropIfExists('activity_logs');
    }
};
