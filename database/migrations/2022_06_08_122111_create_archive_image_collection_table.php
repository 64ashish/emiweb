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
        Schema::create('archive_image_collection', function (Blueprint $table) {
//            $table->id();
            $table->unsignedBigInteger('archive_id');
            $table->unsignedBigInteger('image_collection_id');
            $table->foreign('archive_id')->references('id')->on('archives')->onDelete('cascade');
            $table->foreign('image_collection_id')->references('id')->on('image_collections')->onDelete('cascade');
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
        Schema::dropIfExists('archive_image_collection');
    }
};
