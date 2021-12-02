<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsertAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insert_app', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('call_number')->nullable();
            $table->string('call_receive_number')->nullable();
            $table->dateTime('input_date_time')->nullable();
            $table->string('start_end')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('insert_app');
    }
}
