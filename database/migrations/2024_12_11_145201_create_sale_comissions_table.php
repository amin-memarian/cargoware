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
        Schema::create('sale_comissions', function (Blueprint $table) {
            $table->id();
            $table->string('airline_id');
            $table->string('m');
            $table->string('n');
            $table->string('c_45');
            $table->string('c_100');
            $table->string('c_300');
            $table->string('c_500');
            $table->string('c_1000');
            $table->string('created_at');
            $table->string('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_comissions');
    }
};
