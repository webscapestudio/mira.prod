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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            //main_information
            $table->string('title_main');
            $table->text('description_main');
            //project
            $table->string('slug');
            $table->string('title_first');
            $table->string('title_second');
            $table->string('subtitle');
            $table->text('description');
            $table->string('image_main');
            $table->string('image_cover');
            $table->string('image_informational');
            $table->string('pictures_description')->nullable();
            $table->integer('price');
            $table->string('units_title');
            $table->date('construction_date');
            $table->boolean('is_announcement')->nullable();
            $table->boolean('is_unique')->nullable();
            //sort position
            $table->integer('sortdd')->nullable();
            //usp
            $table->string('title_usp')->nullable();
            $table->string('description_usp')->nullable();
            $table->string('logo_usp')->nullable();
            $table->string('image_first_usp')->nullable();
            $table->string('image_second_usp')->nullable();
            // location
            $table->string('address');
            $table->string('description_location');
            $table->integer('coordinates_latitude');
            $table->integer('coordinates_longitude');
            $table->string('image_location');

            
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
        Schema::dropIfExists('projects');
    }
};
