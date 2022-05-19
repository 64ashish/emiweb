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
//          table  emigration
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
//          table  emigration part 2

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
