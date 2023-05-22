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
//        MormonShipPassengerRecord
        // original table mormonships
        Schema::create('mormon_ship_passenger_records', function (Blueprint $table) {
            $table->id()->index();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('14');  // default value 14
            $table->integer('old_id')->nullable();
            $table->integer('age')->nullable();
            $table->string('conference')->nullable();
            $table->string('travel_type')->nullable();
            $table->integer('departure_year')->nullable();
            $table->integer('departure_month')->nullable();
            $table->integer('departure_day')->nullable();
            $table->string('destination')->nullable();
            $table->string('dgsnr')->nullable();
            $table->string('image_nr')->nullable();
            $table->string('gsnumber')->nullable();
            $table->string('gender')->nullable();
            $table->string('entry')->nullable();
            $table->string('inclusive_dates')->nullable();
            $table->string('libr_no')->nullable();
            $table->string('volume_nr')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('nationality')->nullable();
            $table->string('residence')->nullable();
            $table->string('residence_country')->nullable();
            $table->string('ship_name')->nullable();
            $table->string('profession')->nullable();
            $table->mediumText('comments')->nullable();
            $table->integer('family_nr')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('birth_country')->nullable();

            $table->timestamps();

            $table->foreign('archive_id')->references('id')->on('archives')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['first_name', 'last_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mormon_ship_passenger_records');
    }
};
