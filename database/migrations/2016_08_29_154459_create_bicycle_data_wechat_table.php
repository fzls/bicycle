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
            $table->integer('bikenum');
            $table->string('guardType');
            $table->integer('id');
            $table->double('lat');
            $table->double('lon');
            $table->integer('len');
            $table->string('name');
            $table->string('number');
            $table->integer('rentcount');
            $table->integer('restorecount');
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
