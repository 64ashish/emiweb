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
//        SwedeInAlaskaRecord
//        original table sia
        Schema::create('swede_in_alaska_records', function (Blueprint $table) {
            $table->id()->index();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('16');
            $table->integer('old_id')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('birth_location')->nullable();
            $table->string('birth_country')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('father_first_name')->nullable();
            $table->string('father_last_name')->nullable();
            $table->string('father_birth_location')->nullable();
            $table->string('father_birth_country')->nullable();
            $table->string('mother_first_name')->nullable();
            $table->string('mother_last_name')->nullable();
            $table->string('mother_birth_location')->nullable();
            $table->string('mother_birth_country')->nullable();
            $table->string('to_america_date')->nullable();
            $table->string('to_america_location')->nullable();
            $table->string('arrival_date_alaska')->nullable();
            $table->string('arrival_location_alaska')->nullable();
            $table->string('profession')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_address')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('partner_last_name')->nullable();
            $table->string('partner_first_name')->nullable();
            $table->string('partner_birth_date')->nullable();
            $table->string('partner_birth_location')->nullable();
            $table->string('partner_birth_country')->nullable();
            $table->string('partner_profession')->nullable();
            $table->string('number_of_children')->nullable();
            $table->string('children_first_name')->nullable();
            $table->string('children_address')->nullable();
            $table->string('children_postal_address')->nullable();
            $table->string('other_relative1_relationship')->nullable();
            $table->string('other_relative1_name')->nullable();
            $table->string('other_relative1_address')->nullable();
            $table->string('other_relative1_postal_address')->nullable();
            $table->string('other_relative2_relationship')->nullable();
            $table->string('other_relative2_name')->nullable();
            $table->string('other_relative2_address')->nullable();
            $table->string('other_relative2_postal_address')->nullable();
            $table->string('death_date')->nullable();
            $table->string('death_location')->nullable();
            $table->string('source')->nullable();
            $table->mediumText('comments')->nullable();
            $table->timestamps();
            $table->foreign('archive_id')->references('id')->on('archives')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['first_name', 'last_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swede_in_alaska_records');
    }
};
