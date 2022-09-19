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

        Schema::create('swedish_american_book_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default('65');
            $table->unsignedBigInteger('archive_id')->default('28');
            $table->integer('old_id')->nullable();
            $table->unsignedBigInteger('book_id');

            $table->text('first_name')->fulltext()->nullable();
            $table->text('last_name')->fulltext()->nullable();
            $table->date('birth_date')->nullable();
            $table->text('birth_place')->nullable();
            $table->text('residence_city')->nullable();
            $table->text('county')->nullable();
            $table->text('state')->nullable();
            $table->text('page_reference')->nullable();

            $table->foreign('book_id')->references('id')->on('swenson_book_data');
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
        Schema::dropIfExists('swedish_american_book_records');
    }
};
