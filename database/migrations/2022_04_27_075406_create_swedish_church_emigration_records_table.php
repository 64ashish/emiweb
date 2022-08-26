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
//        original name: emigration,emigrationpart2
        Schema::create('swedish_church_emigration_records', function (Blueprint $table) {
//          table  emigration
            $table->id();

            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('13');
            $table->integer('old_id')->nullable();
            $table->string('first_name')->nullable()->index();
            $table->string('last_name')->nullable()->index();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable()->index();
            $table->string('last_resident')->nullable()->index();
            $table->string('from_province')->nullable()->index();
            $table->string('profession')->nullable()->index();
            $table->string('birth_place')->nullable()->index();
            $table->string('civil_status')->nullable()->index();
            $table->string('from_parish')->nullable()->index();
            $table->string('birth_parish')->nullable()->index();
            $table->string('hasFamily')->nullable()->index();
            $table->string('record_date')->nullable();
            $table->string('destination_country')->nullable()->index();
            $table->string('secrecy')->nullable();
            $table->text('main_act')->nullable();
            $table->text('act_number')->nullable();
            $table->string('household_examination_volume')->nullable();
            $table->string('emigration_book_volume')->nullable();
            $table->string('emigration_book_note')->nullable();
            $table->string('immigration_note')->nullable();
            $table->string('immigration_date')->nullable();
            $table->string('work_certificate_note')->nullable();
            $table->mediumText('memo')->nullable();
            $table->string('year_act_number')->nullable();
            $table->string('supplement_reference')->nullable();
            $table->string('number_in_emigration_book')->nullable();
            $table->string('before_parish')->nullable();
            $table->string('before_province')->nullable();
            $table->string('before_location')->nullable();
            $table->string('before_country')->nullable();
            $table->string('before_year')->nullable();
            $table->string('father_last_name')->nullable();
            $table->string('father_first_name')->nullable();
            $table->string('father_profession')->nullable();
            $table->string('mother_last_name')->nullable();
            $table->string('mother_first_name')->nullable();
            $table->string('mother_profession')->nullable();
            $table->string('partner_last_name')->nullable();
            $table->string('partner_first_name')->nullable();
            $table->string('partner_profession')->nullable();
            $table->string('birth_location_in_parish')->nullable();
            $table->string('source')->nullable();
            $table->string('notes')->nullable();
            $table->string('birth_location')->nullable();
            $table->string('birth_country')->nullable();
            $table->string('farm_name')->nullable();
            $table->string('page_in_original')->nullable();
            $table->string('country_code')->nullable();
            $table->string('destination_location')->nullable();
            $table->string('source_hfl_batch_number')->nullable();
            $table->string('source_hfl_image_number')->nullable();
            $table->string('source_in_out_batch_number')->nullable();
            $table->string('source_in_out_image_number')->nullable();



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
        Schema::dropIfExists('swedish_church_emigration_records');
    }
};
