<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table)
		{
			$table->increments('id');
			// first_name (string 50)
			$table->string('first_name', 50);
			// last_name (string 50)
			$table->string('last_name', 50);
			// patronymic (string 50)
			$table->string('patronymic', 50);
			// sex (bool)
			$table->integer('sex');
			// birthday (timestamp)
			$table->timestamp('birthday');
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
		Schema::drop('clients');
	}

}
