<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDetalleEntradasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('detalleEntradas', function(Blueprint $table)
		{
			$table->foreign('idEntrada', 'fk_plantas_has_entradas_entradas1')->references('idEntrada')->on('entradas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idPlanta', 'fk_plantas_has_entradas_plantas1')->references('idPlanta')->on('plantas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('detalleEntradas', function(Blueprint $table)
		{
			$table->dropForeign('fk_plantas_has_entradas_entradas1');
			$table->dropForeign('fk_plantas_has_entradas_plantas1');
		});
	}

}
