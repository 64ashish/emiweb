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
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('place')->nullable();
            $table->longText('detail')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->text('total_records')->nullable();
            $table->text('link')->nullable();
            $table->longText('owner_info')->nullable();

            $table->foreign('category_id')
                ->nullable()
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archives');
    }
};
