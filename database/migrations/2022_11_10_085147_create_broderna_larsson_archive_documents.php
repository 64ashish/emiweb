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
        Schema::create('broderna_larsson_archive_documents', function (Blueprint $table) {
            $table->id()->index();
            $table->text('year');
            $table->text('file_name');
            $table->text('has_index');
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
        Schema::dropIfExists('broderna_larsson_archive_documents');
    }
};
