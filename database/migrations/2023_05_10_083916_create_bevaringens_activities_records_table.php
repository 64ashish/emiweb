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
//        BevaringensActivitiesRecord
        Schema::create('bevaringens_activities_records', function (Blueprint $table) {
            $table->id()->index();
            $table->unsignedBigInteger('bevaringens_id');
            $table->text('location')->nullable();
            $table->text('country')->nullable();
            $table->text('time_period')->nullable();
            $table->text('activity')->nullable();
            $table->text('duration')->nullable();
            $table->text('comments')->nullable();
            $table->text('type')->nullable();
            $table->text('description_id')->nullable();
            $table->foreign('bevaringens_id')->references('id')->on('bevaringens_levnadsbeskrivningar_records')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bevaringens_activities_records');
    }
};
