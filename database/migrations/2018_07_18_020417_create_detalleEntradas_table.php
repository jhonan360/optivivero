<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetalleEntradasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalleEntradas', function(Blueprint $table)
		{
			$table->integer('idPlanta')->index('fk_plantas_has_entradas_plantas1_idx');
			$table->integer('idEntrada')->index('fk_plantas_has_entradas_entradas1_idx');
			$table->integer('cantidad');
			$table->decimal('valor', 11);
			$table->timestamps();
			$table->primary(['idPlanta','idEntrada']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('detalleEntradas');
	}

}
