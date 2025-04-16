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
        Schema::create('airlines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
//            $table->string('tariff')->nullable();
            $table->string('ROE')->nullable();
            $table->string('Sale_rate')->nullable();
            $table->string('AWB')->nullable();
            $table->string('AWA')->nullable();
            $table->string('AWC')->nullable();
            $table->string('SCC')->nullable();
            $table->string('SCC_min')->nullable();
            $table->string('TVC')->nullable();
            $table->string('HXC')->nullable();
            $table->string('ATA')->nullable();
            $table->string('ATA_min')->nullable();
            $table->string('ATA_max')->nullable();
            $table->string('TDC')->nullable();
            $table->string('CGC')->nullable();
            $table->string('MCC')->nullable();
            $table->string('INC')->nullable();
            $table->string('MMA')->nullable();
            $table->string('MYC')->nullable();
            $table->string('FEC')->nullable();
            $table->string('XDC')->nullable();
            $table->double('BFC')->nullable();
            $table->double('MAC')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airlines');
    }
};
