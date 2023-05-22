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
//        original name kristiania
        Schema::create('swedish_emigrant_via_kristiania_records', function (Blueprint $table) {
            $table->id()->index();

            $table->unsignedBigInteger('user_id')->default('1');
            $table->unsignedBigInteger('archive_id')->default('7');  // default value 7
            $table->integer('old_id')->nullable();
            $table->string('source_code')->nullable();
            $table->string('constructed')->nullable();
            $table->string('page_nr')->nullable();
            $table->string('row_nr')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('profession')->nullable();
            $table->string('age')->nullable();
            $table->string('home_location')->nullable();
            $table->string('agent')->nullable();
            $table->string('destination')->nullable();
            $table->string('ship')->nullable();
            $table->date('departure_date')->nullable();
            $table->string('cash')->nullable();
            $table->string('payed_amount')->nullable();
            $table->string('traveling_companion')->nullable();

            $table->foreign('archive_id')->references('id')->on('archives')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
//            $table->index(['first_name', 'last_name']);
            $table->index(['first_name', 'last_name'],'sevk_first_name_last_name_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swedish_emigrant_via_kristiania_records');
    }
};
