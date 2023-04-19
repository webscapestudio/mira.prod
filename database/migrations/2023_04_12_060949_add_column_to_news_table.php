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
        Schema::table('news', function (Blueprint $table) {
            $table->integer('sortdd')->nullable();
        });
        Schema::table('banners', function (Blueprint $table) {
            $table->integer('sortdd')->nullable();
        });
        Schema::table('achievements', function (Blueprint $table) {
            $table->integer('sortdd')->nullable();
        });
        Schema::table('about_us', function (Blueprint $table) {
            $table->integer('sortdd')->nullable();
        });
        Schema::table('advantages', function (Blueprint $table) {
            $table->integer('sortdd')->nullable();
        });
        Schema::table('histories', function (Blueprint $table) {
            $table->integer('sortdd')->nullable();
        });
        Schema::table('partners', function (Blueprint $table) {
            $table->integer('sortdd')->nullable();
        });
        Schema::table('vacancies', function (Blueprint $table) {
            $table->integer('sortdd')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('sortdd');
        });
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('sortdd');
        });
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropColumn('sortdd');
        });
        Schema::table('about_us', function (Blueprint $table) {
            $table->dropColumn('sortdd');
        });
        Schema::table('advantages', function (Blueprint $table) {
            $table->dropColumn('sortdd');
        });
        Schema::table('histories', function (Blueprint $table) {
            $table->dropColumn('sortdd');
        });
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn('sortdd');
        });
        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropColumn('sortdd');
        });

    }
};
