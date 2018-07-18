<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePerfilamientoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('perfilamiento', function(Blueprint $table)
		{
			$table->string('cedula', 15)->primary();
			$table->integer('user_id')->index('fk_perfilamiento_user_idx');
			$table->string('nombres', 50);
			$table->string('apellidos', 50);
			$table->string('telefono', 15);
			$table->string('direccion', 100)->nullable();
			$table->string('imagen', 200)->nullable();
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
		Schema::drop('perfilamiento');
	}

}
