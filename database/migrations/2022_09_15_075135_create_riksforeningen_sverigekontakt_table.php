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
//        RsPersonalHistoryRecord
        Schema::create('rs_personal_history_records', function (Blueprint $table) {
//            $table->id();
            $table->id();
            $table->unsignedBigInteger('user_id')->default('68');
            $table->unsignedBigInteger('archive_id')->default('26');
            $table->integer('old_id')->nullable();
            $table->text('source')->nullable();
            $table->text('name')->nullable();
            $table->text('profession')->nullable();
            $table->text('country')->nullable();
            $table->text('filename')->nullable();

//            indexes
            $table->fullText('source')->nullable();
            $table->fullText('name')->nullable();
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
        Schema::dropIfExists('riksforeningen_sverigekontakt_personal_history_records');
    }
};
