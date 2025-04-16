<?php

use App\Models\TurkishRate;
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
        Schema::create(TurkishRate::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(TurkishRate::DESTINATION);
            $table->integer(TurkishRate::MINIMUM);
            $table->double(TurkishRate::NORMAL);
            $table->double(TurkishRate::FORTY_FIVE);
            $table->double(TurkishRate::HUNDRED);
            $table->double(TurkishRate::THREE_HUNDRED);
            $table->double(TurkishRate::FIVE_HUNDRED);
            $table->double(TurkishRate::THOUSAND);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TurkishRate::TABLE);
    }
};


