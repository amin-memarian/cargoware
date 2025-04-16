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
            $table->string(Estimate::USER_ID)->nullable();
            $table->string(Estimate::LOAD_ID)->nullable();
            $table->string(Estimate::AIRLINE_ID);
            $table->string(Estimate::ROE);
            $table->string(Estimate::ESTIMATE);
            $table->string(Estimate::ADMIN_ESTIMATE)->nullable();
            $table->longText(Estimate::REJECTION_REASON)->nullable();
            $table->enum('status', [0, 1])->default(0);
            $table->enum('publish_status', [0, 1])->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Estimate::TABLE);
    }
};
