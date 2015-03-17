<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Videos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(
				'videos',
				function ($table) {

						$table->increments('id')->unsigned();
						$table->string('uuid')->unique();
						
						$table->string('title');
						$table->string('description')->nullable();
						
						$table->boolean('enabled')
									->default(0);
						$table->timestamps();
						$table->softDeletes();
						
						$table->index('id');
				}
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('videos');
	}

}
