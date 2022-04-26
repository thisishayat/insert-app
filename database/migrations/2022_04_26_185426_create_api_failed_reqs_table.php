<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiFailedReqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_failed_reqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('call_number_failed_reqs')->nullable();
            $table->string('call_receive_number_failed_reqs')->nullable();
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
        Schema::dropIfExists('api_failed_reqs');
    }
}
