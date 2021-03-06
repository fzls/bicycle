<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBicycleDataWechatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('bicycle_data_wechat', function (Blueprint $table) {
            $table->increments('record_id');
            $table->string('name');
            $table->string('rentcount');
            $table->string('restorecount');
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
        \Schema::drop('bicycle_data_wechat');
    }
}
