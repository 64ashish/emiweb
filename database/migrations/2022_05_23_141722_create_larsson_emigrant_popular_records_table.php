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
//        original name: larsson_pop
        Schema::create('larsson_emigrant_popular_records', function (Blueprint $table) {
            $table->id()->index();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('19');
            $table->integer('old_id')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('profession')->nullable();
            $table->string('home_location')->nullable();
            $table->string('home_parish')->nullable();
            $table->string('home_province')->nullable();
            $table->string('source_code')->nullable();
            $table->string('letter_date')->nullable();
            $table->string('notes')->nullable();

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
        Schema::dropIfExists('larsson_emigrant_popular_records');
    }
};
