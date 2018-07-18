<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAlmacenDatosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('almacenDatos', function(Blueprint $table)
		{
			$table->foreign('idSeccion', 'fk_recoleccion_secciones1')->references('idSeccion')->on('secciones')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('almacenDatos', function(Blueprint $table)
		{
			$table->dropForeign('fk_recoleccion_secciones1');
		});
	}

}
