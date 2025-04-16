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
        Schema::create('qeshm_air_rates', function (Blueprint $table) {
            $table->id();
            $table->string('destination');
            $table->string('minimum');
            $table->string('normal');
            $table->string('45');
            $table->string('100');
            $table->string('250');
            $table->string('500');
            $table->string('1000');
            $table->string('upload_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qeshm_air_rates');
    }
};
