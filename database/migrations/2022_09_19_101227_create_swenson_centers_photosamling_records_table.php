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
        Schema::create('swenson_center_photosamling_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default('65');
            $table->unsignedBigInteger('archive_id')->default('24');
            $table->integer('old_id')->nullable();
            $table->text('title')->fulltext()->nullable();
            $table->text('description')->fulltext()->nullable();
            $table->text('photographer')->fulltext()->nullable();
            $table->text('studio')->fulltext()->nullable();
            $table->text('place')->fulltext()->nullable();
            $table->text('datum')->nullable();
            $table->text('collection_name')->fulltext()->nullable();
            $table->text('object_id')->nullable();
            $table->text('print_size')->nullable();
            $table->text('file_name')->nullable();


            $table->foreign('archive_id')->references('id')->on('archives')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('swenson_center_photosamling_records');
    }
};
