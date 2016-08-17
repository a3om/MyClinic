<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clinics', function(Blueprint $table)
		{
			$table->increments('id');
			// address (string 255)
			$table->string('address');
			// geo_postition_m (float)
			$table->float('geo_postition_m');
			// geo_postition_l (float)
			$table->float('geo_postition_l');
			// email (string 255)
			$table->string('email', 255);
			// phone1 (string 32)
			$table->string('phone1', 32);
			// phone2 (string 32)
			$table->string('phone2', 32);
			// phone3 (string 32)
			$table->string('phone3', 32);
			// password (string 32)
			$table->string('password', 32);
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
		Schema::drop('clinics');
	}

}
