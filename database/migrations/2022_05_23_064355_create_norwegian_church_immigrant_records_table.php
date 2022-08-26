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
//        NorwegianChurchImmigrantRecord
//        orignal: inorway
        Schema::create('norwegian_church_immigrant_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('13');
            $table->integer('old_id');
            $table->string('source_type')->nullable();
            $table->string('source_area')->nullable();
            $table->integer('source_book_nr')->nullable();
            $table->string('source_period')->nullable();
            $table->integer('source_page_nr')->nullable();
            $table->string('source_place')->nullable();
            $table->integer('family_nr')->nullable();
            $table->integer('nr_in_immigration_book')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('birth_date')->nullable();
            $table->char('sex', 1)->nullable();
            $table->string('profession')->nullable();
            $table->string('civil_status')->nullable();
            $table->char('alone_or_family', 1)->nullable();
            $table->string('from_area')->nullable();
            $table->string('from_country')->nullable();
            $table->string('to_date')->nullable();
            $table->string('to_location')->nullable();
            $table->string('to_fylke')->nullable();
            $table->mediumText('certificates')->nullable();
            $table->mediumText('comment')->nullable();
            $table->string('birth_location')->nullable();
            $table->string('baptism_date')->nullable();
            $table->string('baptism_location')->nullable();
            $table->string('confirmation_date')->nullable();
            $table->string('confirmation_location')->nullable();
            $table->string('marriage_date')->nullable();
            $table->string('marriage_location')->nullable();
            $table->string('secrecy')->nullable();
            $table->string('birth_country')->nullable();
            $table->string('baptism_country')->nullable();
            $table->string('confirmation_country')->nullable();
            $table->string('marriage_country')->nullable();
            $table->string('migration_cause')->nullable();
            $table->string('registered_date')->nullable();
            $table->string('from_county')->nullable();
            $table->string('from_location')->nullable();
            $table->string('signature')->nullable();
            $table->string('farm_name')->nullable();


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
        Schema::dropIfExists('norwegian_church_immigrant_records');
    }
};
