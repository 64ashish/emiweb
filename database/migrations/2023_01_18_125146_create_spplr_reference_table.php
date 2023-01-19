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
        Schema::create('spplr_references', function (Blueprint $table) {
            $table->id();
            $table->text('index_batch_reference')->nullable();
            $table->text('page_one')->nullable();
            $table->text('page_two')->nullable();
            $table->text('image_id')->nullable();
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
        Schema::dropIfExists('spplr_references');
    }
};
