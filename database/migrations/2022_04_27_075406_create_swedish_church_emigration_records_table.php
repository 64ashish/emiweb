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
        Schema::create('swedish_church_emigration_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id')->default('5');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('archive_id');
            $table->string('first_name')->index()->nullable();
            $table->string('last_name')->index()->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->index()->nullable();
            $table->string('last_resident')->index()->nullable();
            $table->string('from_province')->index()->nullable();
            $table->string('profession')->index()->nullable();
            $table->string('birth_place')->index()->nullable();
            $table->string('civil_status')->index()->nullable();
            $table->string('from_parish')->index()->nullable();
            $table->string('birth_parish')->index()->nullable();
            $table->string('hasFamily')->index()->nullable();
            $table->date('record_date')->nullable();
            $table->string('destination_country')->index()->nullable();
            $table->boolean('secrecy')->default(0);
            $table->text('main_act')->nullable();
            $table->text('act_number')->nullable();

            $table->timestamps();


            $table->foreign('archive_id')->references('id')->on('archives')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swedish_church_emigration_records');
    }
};
