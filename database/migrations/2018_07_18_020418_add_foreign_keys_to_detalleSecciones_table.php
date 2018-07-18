<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDetalleSeccionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('detalleSecciones', function(Blueprint $table)
		{
			$table->foreign('idPlanta', 'fk_plantas_has_secciones_plantas1')->references('idPlanta')->on('plantas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idSeccion', 'fk_plantas_has_secciones_secciones1')->references('idSeccion')->on('secciones')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('detalleSecciones', function(Blueprint $table)
		{
			$table->dropForeign('fk_plantas_has_secciones_plantas1');
			$table->dropForeign('fk_plantas_has_secciones_secciones1');
		});
	}

}
