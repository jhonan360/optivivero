<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSeccionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('secciones', function(Blueprint $table)
		{
			$table->foreign('idTipoPlanta', 'fk_secciones_tipoPlanta1')->references('idTipoPlanta')->on('tipoPlanta')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('secciones', function(Blueprint $table)
		{
			$table->dropForeign('fk_secciones_tipoPlanta1');
		});
	}

}
