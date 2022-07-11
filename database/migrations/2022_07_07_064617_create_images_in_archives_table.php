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
        Schema::create('images_in_archives', function (Blueprint $table) {
            $table->id();
            $table->text('context')->nullable();
            $table->unsignedBigInteger('archive_id');  // belongs to this archive
//            $table->text('model_type');
            $table->integer('record_id');
            $table->integer('collection_id')->nullable();
            $table->text('image_name');

            $table->foreign('archive_id')->references('id')->on('archives')->onDelete('cascade');
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
        Schema::dropIfExists('images_in_archives');
    }
};
