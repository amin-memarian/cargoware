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
        Schema::create('airline_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('airline_id');
            $table->string('waybill_no');
            $table->string('from');
            $table->string('to');
            $table->double('gross_weight');
            $table->double('chargeable_weight');
            $table->double('rate');
            $table->double('air_freight');
            $table->json('variables');
            $table->double('other_charges');
            $table->double('tax');
            $table->double('total');
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airline_sales');
    }
};
