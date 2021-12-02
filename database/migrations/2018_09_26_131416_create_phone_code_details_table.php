<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneCodeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('phone_code_details', function (Blueprint $table) {
//            $table->bigIncrements('id');
//            $table->unsignedInteger('country_id')->nullable();
//            $table->string('country')->nullable();
//            $table->string('operator')->nullable();
//            $table->string('destination');
//            $table->string('sms_code')->comment('code sent to mobile');
//            $table->string('code')->nullable()->comment('api return code');
//            $table->string('current_balance')->nullable();
//            $table->boolean('sms_send')->default(0);
//            $table->string('msg_id')->nullable();
//            $table->text('response_msg')->nullable();
//            $table->tinyInteger('status')->default(0)->comment('0.fail,1.success');
//            $table->integer('reason')->nullable()->comment('Msg delivery code');
//            $table->timestamp('created_at')->useCurrent();
//            $table->dateTime('sms_send_at')->nullable();
//            $table->dateTime('response_at')->nullable()->useCurrent();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_code_details');
    }
}
