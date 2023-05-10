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
        Schema::create('bevaringens_professional_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bevaringens_id');
            $table->integer('old_id')->nullable();
            $table->text('industry')->nullable();
            $table->text('branch')->nullable();
            $table->text('profession')->nullable();

            $table->foreign('bevaringens_id')->references('id')->on('bevaringens_levnadsbeskrivningar_records')->onDelete('cascade');

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
        Schema::dropIfExists('bevaringens_professional_records');
    }
};
