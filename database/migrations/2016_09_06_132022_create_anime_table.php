<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnimeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('anime', function(Blueprint $table)
		{
			$table->integer('download_times');
			$table->string('url', 100);
			$table->string('file_name', 200)->nullable();
			$table->string('file_size', 50)->nullable();
			$table->string('download_link', 200)->nullable();
			$table->string('url_1', 100)->nullable();
			$table->string('url_2', 100)->nullable();
			$table->string('url_3', 100)->nullable();
			$table->string('upload_time', 15)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('anime');
	}

}
