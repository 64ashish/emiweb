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
        Schema::create('iceland_emigration_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id')->default('5');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('archive_id');
            $table->string('first_name')->index()->nullable();
            $table->string('middle_name')->index()->nullable();
            $table->string('last_name')->index()->nullable();
            $table->string('original_name')->index()->nullable();
            $table->string('date_of_birth')->index()->nullable();
            $table->string('place_of_birth')->index()->nullable();
            $table->string('destination_country')->index()->nullable();
            $table->string('destination_location')->index()->nullable();
            $table->string('home_location')->index()->nullable();
            $table->string('departure')->index()->nullable();
            $table->string('profession')->index()->nullable();
            $table->string('travel_companion')->index()->nullable();
            $table->string('return_info')->index()->nullable();
            $table->string('travel_method')->index()->nullable();
            $table->string('fathers_name')->index()->nullable();
            $table->string('fathers_birth_location')->index()->nullable();
            $table->string('mothers_name')->index()->nullable();
            $table->string('mothers_birth_location')->index()->nullable();
            $table->string('civil_status')->index()->nullable();
            $table->string('partner_info')->index()->nullable();
            $table->string('children')->index()->nullable();
            $table->string('death_date')->index()->nullable();
            $table->string('death_location')->index()->nullable();
            $table->string('member_of_church')->index()->nullable();
            $table->text('reference')->nullable();
            $table->boolean('genealogy')->index()->nullable();
            $table->string('source')->index()->nullable();
            $table->string('newspaper_info')->index()->nullable();
            $table->text('photo')->nullable();
            $table->text('distction')->nullable();
            $table->text('member_of_organization')->nullable();
            $table->text('comment')->nullable();

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
        Schema::dropIfExists('iceland_emmigration_records');
    }
};
