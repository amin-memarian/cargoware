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
        Schema::create('waybills', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('load_id')->nullable();
            $table->unsignedInteger('load_detail_id')->nullable();
            $table->unsignedInteger('estimate_id')->nullable();
            $table->unsignedInteger('airline_id')->nullable();
            $table->string('airline_name')->nullable();
            $table->string('airline_logo')->nullable();
            $table->string('destination')->nullable();
            $table->double('gross_weight')->nullable();
            $table->double('chargeable_weight')->nullable();
            $table->double('total_amount')->nullable();
            $table->string('total_prepaid')->nullable();
            $table->json('variables')->nullable();
            $table->json('agent_variables')->nullable();
            $table->json('carrier_variables')->nullable();
            $table->double('sum_of_agent_variables')->nullable();
            $table->double('sum_of_carrier_variables')->nullable();
            $table->double('rate')->nullable();
            $table->double('roe')->nullable();
            $table->double('tax')->nullable();
            $table->enum('publish_status', [0, 1])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waybills');
    }
};
