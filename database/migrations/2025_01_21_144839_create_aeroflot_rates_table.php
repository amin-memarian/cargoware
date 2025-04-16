<?php

use App\Models\AeroflotRate;
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
        Schema::create(AeroflotRate::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(AeroflotRate::DESTINATION);
            $table->double(AeroflotRate::MINIMUM);
            $table->double(AeroflotRate::NORMAL);
            $table->double(AeroflotRate::FORTY_FIVE);
            $table->double(AeroflotRate::HUNDRED);
            $table->double(AeroflotRate::THREE_HUNDRED);
            $table->double(AeroflotRate::FIVE_HUNDRED);
            $table->double(AeroflotRate::THOUSAND);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(AeroflotRate::TABLE);
    }
};
