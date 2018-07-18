<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetalleSalidaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalleSalida', function(Blueprint $table)
		{
			$table->integer('idPlanta')->index('fk_plantas_has_salidas_plantas1_idx');
			$table->integer('idSalidas')->index('fk_plantas_has_salidas_salidas1_idx');
			$table->integer('cantidad');
			$table->decimal('valor', 11);
			$table->timestamps();
			$table->primary(['idPlanta','idSalidas']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('detalleSalida');
	}

}
