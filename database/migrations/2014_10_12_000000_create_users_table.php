<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Hekmatinasser\Verta\Verta;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname')->nullable();
            $table->string('mobile')->unique();
            $table->string('is_partner')->default(0);
            $table->string('role')->default('user');
            $table->boolean('status')->default(1);
            $table->string('password')->default(Hash::make('12345678'));
            $table->string('created_at');
            $table->string('updated_at');
        });

        $admin = new \App\Models\User();
        $admin->name = 'admin';
        $admin->mobile = '09029379538';
        $admin->role = 'admin';
        $admin->status = 1;
        $admin->created_at = Verta::now();
        $admin->updated_at = Verta::now();
        $admin->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
