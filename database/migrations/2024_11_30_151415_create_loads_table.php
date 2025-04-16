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
        Schema::create('loads', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('user_id')->nullable();
            $table->string('store');
            $table->string('address');
            $table->string('weight');
            $table->string('size_width')->nullable();
            $table->string('size_height')->nullable();
            $table->string('size_length')->nullable();
            $table->string('pic')->nullable();
            $table->string('count')->nullable();
            $table->string('type')->nullable();
            $table->string('created_at');
            $table->string('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loads');
    }
};
