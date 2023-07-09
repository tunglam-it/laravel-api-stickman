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
        Schema::create('items', function (Blueprint $table) {
            $table->unsignedBigInteger('id',true);
            $table->string('name');
            $table->integer('type')->comment('1-weapon,2-shield,3-helmet,4-accessories');
            $table->integer('atk');
            $table->integer('head_def');
            $table->integer('body_def');
            $table->integer('hp');
            $table->integer('rarity')->comment('1-common,2-fine,3-rare,4-epic');
            $table->integer('stat_increment');
            $table->integer('price_increment');
            $table->integer('max_level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
