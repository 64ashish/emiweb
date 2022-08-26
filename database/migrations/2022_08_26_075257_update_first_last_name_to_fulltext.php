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
        Schema::table('swedish_church_emigration_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('iceland_emigration_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('middle_name');
            $table->fullText('last_name');
        });
        Schema::table('norway_emigration_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('swedish_port_passenger_list_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('swedish_emigration_statistics_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('norwegian_church_immigrant_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('swedish_church_immigrant_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('swedish_immigration_statistics_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('swedish_emigrant_via_kristiania_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('swedish_american_member_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('new_york_passenger_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('mormon_ship_passenger_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('broderna_larsson_archive_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('denmark_emigrations', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('bevaringens_levnadsbeskrivningar_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('surname');
        });
        Schema::table('larsson_emigrant_popular_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('john_ericssons_archive_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('dalslanningar_born_in_america_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('varmlandska_newspaper_notice_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
        Schema::table('swedish_american_church_archive_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name2');
            $table->fullText('last_name');
        });
        Schema::table('swede_in_alaska_records', function (Blueprint $table) {
            //
            $table->fullText('first_name');
            $table->fullText('last_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fulltext', function (Blueprint $table) {
            //
        });
    }
};
