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
            $table->integer('type')->comment('0-weapon,1-shield,2-helmet,3-accessories');
            $table->integer('atk');
            $table->integer('head_def');
            $table->integer('body_def');
            $table->integer('hp');
            $table->integer('rarity')->comment('0-common,1-fine,2-rare,3-epic');
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
