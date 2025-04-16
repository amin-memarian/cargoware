<?php

use App\Models\Estimate;
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
        Schema::create(Estimate::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger(Estimate::ADMIN_ID);
            $table->foreignId(Estimate::USER_ID);
            $table->foreignId(Estimate::LOAD_ID);
            $table->foreignId(Estimate::AIRLINE_ID);
            $table->double(Estimate::ROE);
            $table->double(Estimate::ESTIMATE);
            $table->double(Estimate::ADMIN_ESTIMATE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
};
