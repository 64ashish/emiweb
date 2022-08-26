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
//        SwedishAmericanMemberRecord
//        original table safa
        Schema::create('swedish_american_member_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('15');  // default value 15
            $table->integer('old_id')->nullable();
            $table->string('page')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('birth_parish')->nullable();
            $table->string('birth_county')->nullable();
            $table->string('lodge')->nullable();
            $table->string('lodge_nr')->nullable();
            $table->string('order_type')->nullable();
            $table->string('place')->nullable();
            $table->string('state')->nullable();
            $table->string('film_nr')->nullable();
            $table->string('source')->nullable();

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
        Schema::dropIfExists('swedish_american_member_records');
    }
};
