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
        Schema::create('air_arabia_rates', function (Blueprint $table) {
            $table->id();
            $table->string('destination');
            $table->integer('minimum');
            $table->double('normal');
            $table->double('45');
            $table->double('100');
            $table->double('250');
            $table->double('500');
            $table->double('1000');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_arabia_rates');
    }
};
