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
        Schema::table('project_units', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('series');
            $table->dropColumn('floor');
            $table->dropColumn('view');
        });
        Schema::table('project_units', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('series')->nullable();
            $table->integer('floor')->nullable();
            $table->string('view')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_units', function (Blueprint $table) {
            $table->string('address');
            $table->string('series');
            $table->integer('floor');
            $table->string('view');
        });
    }
};
