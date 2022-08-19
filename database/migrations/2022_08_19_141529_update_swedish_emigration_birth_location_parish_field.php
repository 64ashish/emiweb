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
        Schema::table('swedish_church_emigration_records', function (Blueprint $table) {
            //
            $table->renameColumn('birth_place', 'from_location');
            $table->text('birth_province')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('swedish_church_emigration_records', function (Blueprint $table) {
            //
        });
    }
};
