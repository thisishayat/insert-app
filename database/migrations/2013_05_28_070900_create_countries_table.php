<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('countries', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('country_code',10);
//            $table->string('country_name',100);
//            $table->string('phone_code',45)->nullable();
//            $table->timestamp('created_at')->useCurrent()->nullable();
//
//            $table->unique('country_name');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
