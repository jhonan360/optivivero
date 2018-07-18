<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEstadosSolicitudesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('estadosSolicitudes', function(Blueprint $table)
		{
			$table->foreign('idSolicitud', 'fk_estadosSolicitudes_solicitudes1')->references('idSolicitud')->on('solicitudes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('estadosSolicitudes', function(Blueprint $table)
		{
			$table->dropForeign('fk_estadosSolicitudes_solicitudes1');
		});
	}

}
