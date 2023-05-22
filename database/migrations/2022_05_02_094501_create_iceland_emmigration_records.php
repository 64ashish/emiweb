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
//        original name ealand
        Schema::create('iceland_emigration_records', function (Blueprint $table) {
            $table->id()->index();
            $table->integer('old_id')->nullable();
            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('21');
            $table->string('first_name')->nullable()->index();
            $table->string('middle_name')->nullable()->index();
            $table->string('last_name')->nullable()->index();
            $table->string('original_name')->nullable()->index();
            $table->string('date_of_birth')->nullable()->index();
            $table->string('place_of_birth')->nullable()->index();
            $table->string('destination_country')->nullable()->index();
            $table->string('destination_location')->nullable()->index();
            $table->string('home_location')->nullable()->index();
            $table->string('departure')->nullable()->index();
            $table->string('profession')->nullable()->index();
            $table->string('travel_companion')->nullable()->index();
            $table->string('return_info')->nullable()->index();
            $table->string('travel_method')->nullable()->index();
            $table->string('fathers_name')->nullable()->index();
            $table->string('fathers_birth_location')->nullable()->index();
            $table->string('mothers_name')->nullable()->index();
            $table->string('mothers_birth_location')->nullable()->index();
            $table->string('civil_status')->nullable()->index();
            $table->string('partner_info')->nullable()->index();
            $table->string('children')->nullable()->index();
            $table->string('death_date')->nullable()->index();
            $table->string('death_location')->nullable()->index();
            $table->string('member_of_church')->nullable()->index();
            $table->text('reference')->nullable();
            $table->string('genealogy')->nullable()->index();
            $table->string('source')->nullable()->index();
            $table->string('newspaper_info')->nullable()->index();
            $table->text('photo')->nullable();
            $table->text('distction')->nullable();
            $table->text('member_of_organization')->nullable();
            $table->text('comment')->nullable();

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
        Schema::dropIfExists('iceland_emmigration_records');
    }
};
