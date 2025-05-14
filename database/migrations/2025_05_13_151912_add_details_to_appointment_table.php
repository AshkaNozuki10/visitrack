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
        Schema::table('appointment', function (Blueprint $table) {
            $table->string('appointment_type')->nullable();
            $table->string('entity')->nullable();
            $table->string('purpose_of_visit')->nullable();
            $table->string('department')->nullable();
            $table->string('building')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->dropColumn(['appointment_type', 'entity', 'purpose', 'department', 'building']);
        });
    }
};
