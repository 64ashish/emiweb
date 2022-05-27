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
//        original table varmlandpaperitems
        Schema::create('varmlandska_newspaper_notice_records', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('17');

            $table->integer('old_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('newspaper')->nullable();
            $table->integer('article_year')->nullable();
            $table->integer('article_month')->nullable();
            $table->integer('article_day')->nullable();
            $table->string('places')->nullable();
            $table->string('death_parish')->nullable();
            $table->string('death_country')->nullable();
            $table->mediumText('notes')->nullable();
            $table->string('archive_reference')->nullable();
            $table->string('file_name')->nullable();
            $table->string('type')->nullable();
            $table->integer('birth_year')->nullable();
            $table->integer('birth_month')->nullable();
            $table->integer('birth_day')->nullable();
            $table->integer('death_year')->nullable();
            $table->integer('death_month')->nullable();
            $table->integer('death_day')->nullable();
            $table->string('birth_location')->nullable();


            $table->timestamps();

            $table->foreign('archive_id')->references('id')->on('archives')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('varmlandska_newspaper_notice_records');
    }
};
