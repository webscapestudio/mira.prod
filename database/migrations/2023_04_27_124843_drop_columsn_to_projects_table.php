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
        Schema::table('projects', function (Blueprint $table) {
            //main_information
            $table->dropColumn('title_main');
            $table->dropColumn('description_main');
            //project
            $table->dropColumn('title_second');
        });
        Schema::table('projects', function (Blueprint $table) {

            $table->string('title_second')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
             //main_information
             $table->string('title_main');
             $table->text('description_main');
                         //project
             $table->string('title_second');
        });
        Schema::table('projects', function (Blueprint $table) {

            $table->dropColumn('title_second')->nullable();
        });
    }
};
