<?php

use App\Models\SalesTeam;
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
        Schema::create(SalesTeam::Table, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger(SalesTeam::ADMIN_ID);
            $table->string(SalesTeam::TEAM_NAME);
            $table->unsignedInteger(SalesTeam::MANAGER_ID);
            $table->text(SalesTeam::SALES_STAFF);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SalesTeam::Table);
    }
};
