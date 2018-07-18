<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetalleSeccionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalleSecciones', function(Blueprint $table)
		{
			$table->integer('idPlanta')->index('fk_plantas_has_secciones_plantas1_idx');
			$table->integer('idSeccion')->index('fk_plantas_has_secciones_secciones1_idx');
			$table->integer('cantidad');
			$table->primary(['idPlanta','idSeccion']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('detalleSecciones');
	}

}
