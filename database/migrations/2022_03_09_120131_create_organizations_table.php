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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('phone')->nullable();
            $table->text('email')->nullable();
            $table->text('location')->nullable();
            $table->text('address');
            $table->text('city');
            $table->text('postcode');
            $table->text('province'); //can be replaced with id
            $table->text('fax')->nullable();
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
        Schema::dropIfExists('organizations');
    }
};
