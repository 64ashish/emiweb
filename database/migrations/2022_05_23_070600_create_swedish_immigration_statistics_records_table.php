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
//        original name scbi
        Schema::create('swedish_immigration_statistics_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('9');  // default value 9
            $table->integer('old_id')->nullable();
            $table->string('source')->nullable();
            $table->string('svar_batch_nr')->nullable();
            $table->string('svar_image_nr')->nullable();
            $table->integer('to_year')->nullable();
            $table->string('to_province')->nullable();
            $table->string('to_parish')->nullable();
            $table->string('sex')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('profession')->nullable();
            $table->integer('birth_year')->nullable();
            $table->integer('birth_month')->nullable();
            $table->integer('birth_day')->nullable();
            $table->string('from_country')->nullable();
            $table->mediumText('comments')->nullable();
            $table->integer('family_nr')->nullable();
            $table->string('nationality')->nullable();
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
        Schema::dropIfExists('swedish_immigration_statistics_records');
    }
};
