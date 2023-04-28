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
        Schema::create('project_mains', function (Blueprint $table) {
            $table->id();
            $table->string('title_main');
            $table->text('description_main');
            $table->integer('sortdd')->nullable();
            $table->integer('project_mainable_id');
            $table->string('project_mainable_type');
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
        Schema::dropIfExists('project_mains');
    }
};
