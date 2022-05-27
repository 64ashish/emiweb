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
            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->text('sex')->nullable();
            $table->integer('age')->index()->nullable();
            $table->string('birth_place')->index()->nullable();
            $table->string('last_resident')->index()->nullable();
            $table->string('profession')->index()->nullable();
            $table->string('destination_city')->index()->nullable();
            $table->string('destination_country')->index()->nullable();
            $table->text('ship_name')->nullable();
            $table->date('traveled_on')->index()->nullable();
            $table->text('contract_number')->nullable();
            $table->longText('comment')->nullable();
            $table->boolean('secrecy')->default(0);
            $table->text('travel_type');
            $table->text('source');
            $table->text('dduid');
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
