<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tbl_qr_codes', function (Blueprint $table) {
            $table->bigIncrements('qr_id');
            $table->unsignedBigInteger('user_id');
            $table->text('qr_text');
            $table->string('qr_picture');
            $table->string('qr_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_qr_codes');
    }
};
