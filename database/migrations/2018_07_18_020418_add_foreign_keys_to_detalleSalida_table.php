<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDetalleSalidaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('detalleSalida', function(Blueprint $table)
		{
			$table->foreign('idPlanta', 'fk_plantas_has_salidas_plantas1')->references('idPlanta')->on('plantas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idSalidas', 'fk_plantas_has_salidas_salidas1')->references('idSalidas')->on('salidas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('detalleSalida', function(Blueprint $table)
		{
			$table->dropForeign('fk_plantas_has_salidas_plantas1');
			$table->dropForeign('fk_plantas_has_salidas_salidas1');
		});
	}

}
