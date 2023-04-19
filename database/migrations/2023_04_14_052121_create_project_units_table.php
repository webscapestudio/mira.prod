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
        Schema::create('project_units', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('type');
            $table->string('series');
            $table->integer('price');
            $table->string('area');
            $table->string('bedrooms_quantity')->nullable();
            $table->string('bathrooms_quantity');
            $table->integer('floor');
            $table->string('view');
            $table->integer('sortdd')->nullable();
            $table->integer('project_unitable_id');
            $table->string('project_unitable_type');
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
        Schema::dropIfExists('project_units');
    }
};
