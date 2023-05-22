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
        //        original name: scbe
        Schema::create('swedish_emigration_statistics_records', function (Blueprint $table) {
            $table->id()->index();
            $table->integer('old_id')->nullable();

            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('9');
            $table->string('source')->nullable();
            $table->string('svar_batch_number')->nullable();
            $table->string('svar_image_number')->nullable();
            $table->string('from_year')->nullable();
            $table->string('from_province')->nullable();
            $table->string('from_parish')->nullable();
            $table->string('gender')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('profession')->nullable();
            $table->string('birth_year')->nullable();
            $table->string('birth_month')->nullable();
            $table->string('birth_day')->nullable();
            $table->string('destination')->nullable();
            $table->mediumText('comments')->nullable();
            $table->string('last_modified')->nullable();
            $table->string('family_number')->nullable();
            $table->string('nationality')->nullable();
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
        Schema::dropIfExists('swedish_emigration_statistics_records');
    }
};
