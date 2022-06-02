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
//        original table saka
        Schema::create('swedish_american_church_archive_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('2');  // default value 2

            $table->string('page')->nullable();
            $table->string('last_name')->nullable();
            $table->string('last_name2')->nullable();
            $table->string('first_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('birth_parish')->nullable();
            $table->string('birth_province')->nullable();
            $table->string('immigration_date')->nullable();
            $table->string('emigration_parish')->nullable();
            $table->string('emigration_province')->nullable();
            $table->string('arrival_date_this_place')->nullable();
            $table->string('arrived_from_place')->nullable();
            $table->string('arrived_from_county')->nullable();
            $table->string('arrived_from_state')->nullable();
            $table->string('death_date')->nullable();
            $table->string('family_nr')->nullable();
            $table->string('source')->nullable();
            $table->string('immigrated_to_place')->nullable();
            $table->string('immigrated_to_state')->nullable();
            $table->integer('old_id')->nullable();
            $table->smallInteger('birth_year')->nullable();
            $table->tinyInteger('birth_month')->nullable();
            $table->tinyInteger('birth_day')->nullable();
            $table->smallInteger('immigration_year')->nullable();
            $table->tinyInteger('immigration_month')->nullable();
            $table->tinyInteger('immigration_day')->nullable();
            $table->smallInteger('death_year')->nullable();
            $table->tinyInteger('death_month')->nullable();
            $table->tinyInteger('death_day')->nullable();

            $table->timestamps();

            $table->foreign('archive_id')->references('id')->on('archives')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swedish_american_church_archive_records');
    }
};
