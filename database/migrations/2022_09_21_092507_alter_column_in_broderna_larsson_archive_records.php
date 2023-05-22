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
//        Schema::table('broderna_larsson_archive_records', function (Blueprint $table) {
//            //
//            $table->renameColumn('archive_name', 'archives_name');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('broderna_larsson_archive_records', function (Blueprint $table) {
            //
        });
    }
};
