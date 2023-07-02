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
        Schema::create('item_users', function (Blueprint $table) {
            $table->unsignedBigInteger('id',true);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->integer('current_level');
            $table->integer('status')->default('2')->comment('1-on body,2-invent');
            $table->integer('atk');
            $table->integer('body_def');
            $table->integer('head_def');
            $table->integer('hp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_users');
    }
};
