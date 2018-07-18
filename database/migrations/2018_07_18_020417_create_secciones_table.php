<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSeccionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('secciones', function(Blueprint $table)
		{
			$table->integer('idSeccion', true);
			$table->integer('idTipoPlanta')->index('fk_secciones_tipoPlanta1_idx');
			$table->string('nombre', 45)->unique('nombre_UNIQUE');
			$table->integer('espacioTotal');
			$table->text('observacion', 65535)->nullable();
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
		Schema::drop('secciones');
	}

}
