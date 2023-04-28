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
        Schema::table('project_progress_points', function (Blueprint $table) {
            $table->dropColumn('image_main');
            $table->dropColumn('video');
            $table->dropColumn('media_description');
        });
        Schema::table('project_progress_points', function (Blueprint $table) {
            $table->string('image_main')->nullable();
            $table->string('video')->nullable();
            $table->string('media_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_progress_points', function (Blueprint $table) {
            $table->string('image_main');
            $table->string('video');
            $table->string('media_description');
        });
        Schema::table('project_progress_points', function (Blueprint $table) {
            $table->dropColumn('image_main');
            $table->dropColumn('video');
            $table->dropColumn('media_description');
        });
    }
};
