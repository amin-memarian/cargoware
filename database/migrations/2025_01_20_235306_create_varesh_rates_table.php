<?php

use App\Models\VareshRate;
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
        Schema::create(VareshRate::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(VareshRate::DESTINATION);
            $table->integer(VareshRate::MINIMUM);
            $table->integer(VareshRate::NORMAL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(VareshRate::TABLE);
    }
};
