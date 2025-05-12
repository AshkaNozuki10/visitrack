<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->string('appointment_type')->nullable();
            $table->string('entity')->nullable();
            $table->string('purpose')->nullable();
            $table->string('department')->nullable();
            $table->string('building')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->dropColumn(['appointment_type', 'entity', 'purpose', 'department', 'building']);
        });
    }
}; 