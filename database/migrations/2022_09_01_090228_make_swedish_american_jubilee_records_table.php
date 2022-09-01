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
        Schema::create('swedish_american_jubilee_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('23');
            $table->integer('old_id')->nullable();

            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('remarks')->nullable();
            $table->string('time_period')->nullable();
            $table->string('state')->nullable();
            $table->string('county')->nullable();
            $table->string('city')->nullable();
            $table->string('source')->nullable();
            $table->string('page')->nullable();
            $table->string('file_name')->nullable();
            $table->string('emi_web_lan')->nullable();
            $table->string('emi_web_forsamling')->nullable();
            $table->string('emi_web_emigration_year')->nullable();
            $table->string('emi_web_akt_nr')->nullable();
            $table->string('date_created')->nullable();
            $table->string('file_format')->nullable();
            $table->string('resolution')->nullable();
            $table->string('secrecy')->nullable();

            $table->fullText('title');
            $table->fullText('description');
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
        Schema::dropIfExists('swedish_american_jubilee_records');
    }
};
