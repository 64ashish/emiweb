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
        Schema::create('scerc_photo_records', function (Blueprint $table) {
            $table->id();
            $table->integer('old_id')->nullable();
            $table->unsignedBigInteger('scerc_id');
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->text('time_period')->nullable();
            $table->text('type')->nullable();
            $table->text('country')->nullable();
            $table->text('state_province_county')->nullable();
            $table->text('locality')->nullable();
            $table->text('persons_on_photo')->nullable();
            $table->text('photographer')->nullable();
            $table->text('file_name')->nullable();
            $table->text('secrecy')->nullable();
            $table->text('archive_reference')->nullable();

            $table->fullText('title');
            $table->fullText('description');
            $table->foreign('scerc_id')->references('id')->on('swedish_church_emigration_records')->onDelete('cascade');
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
        Schema::dropIfExists('scerc_photo_records');
    }
};
