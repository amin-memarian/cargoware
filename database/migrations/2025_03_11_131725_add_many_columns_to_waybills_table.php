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
        Schema::table('waybills', function (Blueprint $table) {
            $table->string('sender_name')->after('tax')->nullable();
            $table->string('sender_address')->after('sender_name')->nullable();
            $table->string('receiver_name')->after('sender_address')->nullable();
            $table->string('receiver_address')->after('receiver_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('waybills', function (Blueprint $table) {
            //
        });
    }
};
