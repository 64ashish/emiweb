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
        // original: immigration
        Schema::create('swedish_church_immigrant_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('6');
            $table->integer('old_id')->nullable();  // id from old records
            $table->string('to_parish')->nullable();
            $table->string('to_county')->nullable();
            $table->date('to_date')->nullable();
            $table->string('last_name')->nullable();
            $table->string('farm_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('profession')->nullable();
            $table->string('page_in_original')->nullable();
            $table->string('to_location')->nullable();
            $table->string('from_location')->nullable();
            $table->date('from_date')->nullable();
            $table->string('from_country_code')->nullable();
            $table->char('sex', 1)->nullable();
            $table->tinyInteger('secrecy')->nullable();
            $table->string('civil_status')->nullable();
            $table->char('alone_or_family', 1)->nullable();
            $table->smallInteger('main_act')->nullable();
            $table->smallInteger('act_nr')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_parish')->nullable();
            $table->string('birth_county')->nullable();
            $table->string('birth_location')->nullable();
            $table->string('birth_country')->nullable();
            $table->string('notes')->nullable();
            $table->mediumText('comment')->nullable();
            $table->string('nr_in_immigration_book')->nullable();
            $table->string('before_from_parish')->nullable();
            $table->date('before_from_date')->nullable();
            $table->string('before_from_act_nr')->nullable();
            $table->string('again_to_country')->nullable();
            $table->date('again_to_date')->nullable();
            $table->string('again_to_act_nr')->nullable();
            $table->string('source')->nullable();
            $table->string('orebro_act_nr')->nullable();
            $table->string('source_hfl_batch_nr')->nullable();
            $table->string('source_hfl_image_nr')->nullable();
            $table->string('source_in_out_batch_nr')->nullable();
            $table->string('source_in_out_image_nr')->nullable();
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
        Schema::dropIfExists('swedish_church_immigrant_records');
    }
};
