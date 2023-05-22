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
        Schema::create('bevaringens_levnadsbeskrivningar_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('22');  // default value 22
            $table->integer('old_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('company')->nullable();
            $table->string('no_in_enrollment_length')->nullable();
            $table->integer('year_class')->nullable();
            $table->integer('no_for_roller_guidance_area')->nullable();
            $table->string('letter_date')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('residence_at_the_time_of_enrolment')->nullable();
            $table->mediumText('comments')->nullable();
            $table->string('file_name')->nullable();
            $table->string('source_reference')->nullable();
            $table->integer('picture_no')->nullable();
            $table->string('education_level')->nullable();
            $table->integer('number_of_places_mentioned')->nullable();
            $table->boolean('description_with_full_text')->nullable();
            $table->boolean('born_outside_varmland')->nullable();
            $table->boolean('family')->nullable();
            $table->integer('occupation_1')->nullable();
            $table->integer('occupation_2')->nullable();
            $table->integer('profession_3')->nullable();
            $table->integer('profession_4')->nullable();
            $table->string('other_professions')->nullable();



            $table->foreign('archive_id')->references('id')->on('archives')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->index(['first_name', 'last_name'],'blb_first_name_last_name_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bevaringens_levnadsbeskrivningar_records');
    }
};
