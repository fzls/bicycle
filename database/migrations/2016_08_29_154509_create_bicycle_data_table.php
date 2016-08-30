<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBicycleDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('bicycle_data', function (Blueprint $table) {
            $table->increments('record_id');
            $table->string('id');
            $table->string('name');
            $table->double('longitude');
            $table->double('latitude');
            $table->integer('enHireNum');
            $table->integer('disHireNum');
            $table->boolean('isSelected');
            $table->integer('type');
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
        \Schema::drop('bicycle_data');
    }
}
