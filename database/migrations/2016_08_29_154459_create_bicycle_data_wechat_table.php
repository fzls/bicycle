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
            $table->string('address');
            $table->string('areaname');
            $table->string('bikenum');
            $table->bigInteger('createTime');
            $table->string('guardType');
            $table->integer('id');
            $table->string('lat');
            $table->string('len');
            $table->string('lon');
            $table->string('name');
            $table->string('number');
            $table->string('rentcount');
            $table->string('restorecount');
            $table->string('serviceType');
            $table->integer('sort');
            $table->string('stationPhone');
            $table->string('stationPhone2');
            $table->string('useflag');
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
