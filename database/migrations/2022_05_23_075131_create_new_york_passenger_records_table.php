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

//        original table nypassengers
        Schema::create('new_york_passenger_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('3');  // default value 3
            $table->integer('old_id')->nullable();
            $table->string('image_file_name')->nullable();
            $table->string('image_folder')->nullable();
            $table->string('prefix')->nullable();
            $table->string('given')->nullable();
            $table->string('surname')->nullable();
            $table->string('suffix')->nullable();
            $table->string('alias_prefix')->nullable();
            $table->string('alias_given')->nullable();
            $table->string('alias_surname')->nullable();
            $table->string('alias_suffix')->nullable();
            $table->string('gender')->nullable();
            $table->string('nativity')->nullable();
            $table->string('ethnicity_nationality')->nullable();
            $table->string('last_residence')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('birthday')->nullable();
            $table->string('birth_month')->nullable();
            $table->string('birth_year')->nullable();
            $table->string('ship_name')->nullable();
            $table->string('port_of_departure')->nullable();
            $table->string('port_of_arrival')->nullable();
            $table->string('port_arrival_state')->nullable();
            $table->string('port_arrival_country')->nullable();
            $table->string('arrival_day')->nullable();
            $table->string('arrival_month')->nullable();
            $table->string('arrival_year')->nullable();
            $table->string('age')->nullable();
            $table->string('age_months')->nullable();
            $table->string('place_of_origin')->nullable();
            $table->string('archive_name')->nullable();
            $table->string('archive_location')->nullable();
            $table->string('series_number')->nullable();
            $table->string('record_group_name')->nullable();
            $table->string('record_group_number')->nullable();
            $table->string('friend_prefix')->nullable();
            $table->string('friend_given')->nullable();
            $table->string('friend_surname')->nullable();
            $table->string('friend_suffix')->nullable();
            $table->string('microfilm_roll')->nullable();
            $table->string('destination')->nullable();
            $table->string('family_id')->nullable();
            $table->string('birth_other')->nullable();
            $table->string('form_type')->nullable();
            $table->string('comments')->nullable();
            $table->string('page_number')->nullable();
            $table->string('airline')->nullable();
            $table->string('flight_number')->nullable();
            $table->string('list_number')->nullable();
            $table->string('ship_id')->nullable();
            $table->string('image_number')->nullable();
            $table->string('microfilm_serial')->nullable();
            $table->string('arrival_month_no')->nullable();
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
        Schema::dropIfExists('new_york_passenger_records');
    }
};
