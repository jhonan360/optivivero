<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDetalleSolicitudTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('detalleSolicitud', function(Blueprint $table)
		{
			$table->foreign('idPlanta', 'fk_solicitudes_has_plantas_plantas1')->references('idPlanta')->on('plantas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idSolicitud', 'fk_solicitudes_has_plantas_solicitudes1')->references('idSolicitud')->on('solicitudes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('detalleSolicitud', function(Blueprint $table)
		{
			$table->dropForeign('fk_solicitudes_has_plantas_plantas1');
			$table->dropForeign('fk_solicitudes_has_plantas_solicitudes1');
		});
	}

}
