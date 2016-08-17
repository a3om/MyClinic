<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctors', function(Blueprint $table)
		{
			$table->increments('id');
			// first_name (string 50)
			$table->string('first_name', 50);
			// last_name (string 50)
			$table->string('last_name', 50);
			// patronymic (string 50)
			$table->string('patronymic', 50);
			// photo (string 255)
			$table->string('photo', 255);
			// phone (string 32)
			$table->string('phone', 32);
			// address (string 255) / адрес в поликлинике - этаж, кабинет и т.д.
			$table->string('address', 32);
			// description (text)
			$table->text('description');
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
		Schema::drop('doctors');
	}

}
