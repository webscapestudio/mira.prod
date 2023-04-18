<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('text_size');
            $table->string('image_desc');
            $table->string('image_mob');
            $table->timestamps();
        });
        Schema::create('about_achievements', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('addition');
            $table->text('description');
            $table->integer('about_achievementable_id');
            $table->string('about_achievementable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('about_achievements');
        Schema::dropIfExists('about_us');
    }
};
