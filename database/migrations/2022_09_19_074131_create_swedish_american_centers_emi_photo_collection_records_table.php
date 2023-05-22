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
//        SwedishAmericanCentersEmigrantPhotoCollectionRecord SwedishUsaCentersEmiPhotoRecord
        Schema::create('swedish_usa_centers_emi_photo_records', function (Blueprint $table) {
            $table->id()->index();
            $table->unsignedBigInteger('user_id')->default('4');
            $table->unsignedBigInteger('archive_id')->default('27');
            $table->integer('old_id')->nullable();

            $table->text('description')->nullable();
            $table->text('location')->nullable();
            $table->text('country')->nullable();
            $table->text('photo_owner')->nullable();
            $table->text('time_period')->nullable();
            $table->text('film_number')->nullable();
            $table->text('negative')->nullable();
            $table->text('file_name')->nullable();

            $table->fullText('description')->nullable();
            $table->fullText('country')->nullable();
            $table->foreign('archive_id')->references('id')->on('archives')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swedish_american_centers_emigrant_photo_collection_records');
    }
};
