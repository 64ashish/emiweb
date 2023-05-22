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
//        ObituariesSweUsaNewspapersRecords
        Schema::create('obituaries_swe_usa_newspapers_records', function (Blueprint $table) {
            $table->id()->index();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('29');  // default value 29
            $table->integer('old_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('death_location')->nullable();
            $table->string('death_state')->nullable();
            $table->string('death_date')->nullable();
            $table->string('age_year')->nullable();
            $table->string('age_month')->nullable();
            $table->string('age_day')->nullable();
            $table->string('location_in_sweden')->nullable();
            $table->string('county_in_sweden')->nullable();
            $table->string('arrival_year')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('svam_newspaper_id')->nullable();
            $table->string('source_date')->nullable();
            $table->string('comments')->nullable();
            $table->string('from_parish')->nullable();
            $table->string('from_province')->nullable();
            $table->string('from_year')->nullable();
            $table->string('act_nr')->nullable();
            $table->string('file_name')->nullable();

            $table->timestamps();
            $table->foreign('archive_id')->references('id')->on('archives')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['first_name', 'last_name'],'osunr_first_name_last_name_index');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('obituaries_swedish_american_newspapers_records', function (Blueprint $table) {
            //
        });
    }
};
