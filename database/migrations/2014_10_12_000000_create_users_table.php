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
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id',true);
            $table->string('username')->unique();
            $table->string('password');
            $table->integer('gold')->default(500);
            $table->integer('diamonds')->default(100);
            $table->integer('energy')->default(20);
            $table->integer('level')->default(1);
            $table->integer('passed_stage')->default(1);
            $table->integer('exp_profile')->default(0);
            $table->integer('eliminated_enemy')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
