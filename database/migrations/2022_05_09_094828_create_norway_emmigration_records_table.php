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
//        original enorway
        Schema::create('norway_emigration_records', function (Blueprint $table) {
            $table->id();
            $table->integer('old_id')->nullable();

            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('20');
            $table->string('source_type')->nullable();
            $table->string('source_area')->nullable();
            $table->string('source_book_number')->nullable();
            $table->string('source_period')->nullable();
            $table->integer('source_page_number')->nullable();
            $table->string('source_place')->nullable();
            $table->integer('family_number')->nullable();
            $table->integer('number_in_emigration_book')->nullable();
            $table->string('first_name')->nullable()->index();
            $table->string('last_name')->nullable()->index();
            $table->string('birth_date')->nullable()->index();
            $table->string('sex')->nullable();
            $table->string('profession')->nullable();
            $table->string('civil_status')->nullable()->index();
            $table->string('registered_date')->nullable();
            $table->string('from_date')->nullable();
            $table->string('from_location')->nullable()->index();
            $table->string('from_region')->nullable()->index();
            $table->string('destination_location')->nullable()->index();
            $table->string('destination_area')->nullable()->index();
            $table->string('destination_county')->nullable()->index();
            $table->string('destination_country')->nullable()->index();
            $table->mediumText('certificates')->nullable();
            $table->mediumText('comment')->nullable();
            $table->string('secrecy')->nullable();
            $table->string('signature')->nullable();
            $table->string('birth_country')->nullable()->index();
            $table->string('birth_location')->nullable()->index();
            $table->string('page_link')->nullable();
            $table->string('image_link')->nullable();


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
        Schema::dropIfExists('norway_emmigration_records');
    }
};
