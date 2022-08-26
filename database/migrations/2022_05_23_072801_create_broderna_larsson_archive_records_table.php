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

//        original name larsson
        Schema::create('broderna_larsson_archive_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('11');  // default value 11
            $table->integer('old_id');
            $table->string('archive_reference')->nullable();
            $table->string('source_code')->nullable();
            $table->string('archive_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('letter_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('profession')->nullable();
            $table->string('home_location')->nullable();
            $table->string('home_parish')->nullable();
            $table->string('home_county')->nullable();
            $table->string('home_country')->nullable();
            $table->string('geographical_extent')->nullable();
            $table->string('created_by')->nullable();
            $table->string('language')->nullable();
            $table->mediumText('key_words')->nullable();
            $table->string('type')->nullable();
            $table->string('format')->nullable();
            $table->string('number_of_pages')->nullable();
            $table->string('file_name')->nullable();
            $table->mediumText('comments')->nullable();

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
        Schema::dropIfExists('broderna_larsson_archive_records');
    }
};
