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
        Schema::create('scerc_document_records', function (Blueprint $table) {
            $table->id()->index();
            $table->integer('old_id')->nullable();
            $table->unsignedBigInteger('scerc_id');
            $table->text('description')->nullable();
            $table->text('type')->nullable();
            $table->text('file_name')->nullable();
            $table->text('archive_reference')->nullable();
            $table->text('secrecy')->nullable();
            $table->text('time_period')->nullable();
            $table->timestamps();

            $table->fullText('description');
            $table->foreign('scerc_id')->references('id')->on('swedish_church_emigration_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scerc_document_records');
    }
};
