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
//        original table: edenmark
        Schema::create('denmark_emigrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('1');

            $table->integer('old_id')->nullable();
            $table->string('first_name')->nullable()->index();
            $table->string('last_name')->nullable()->index();
            $table->text('sex')->nullable();
            $table->integer('age')->nullable()->index();
            $table->string('birth_place')->nullable()->index();
            $table->string('last_resident')->nullable()->index();
            $table->string('profession')->nullable()->index();
            $table->string('destination_city')->nullable()->index();
            $table->string('destination_country')->nullable()->index();
            $table->text('ship_name')->nullable();
            $table->string('traveled_on')->nullable()->index();
            $table->text('contract_number')->nullable();
            $table->longText('comment')->nullable();
            $table->boolean('secrecy')->nullable();
            $table->text('travel_type')->nullable();
            $table->text('source')->nullable();
            $table->text('dduid')->nullable();
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
        Schema::dropIfExists('denmark_emigrations');
    }
};
