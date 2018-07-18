<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetalleSolicitudTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalleSolicitud', function(Blueprint $table)
		{
			$table->integer('idSolicitud')->index('fk_solicitudes_has_plantas_solicitudes1_idx');
			$table->integer('idPlanta')->index('fk_solicitudes_has_plantas_plantas1_idx');
			$table->integer('cantidad');
			$table->decimal('valor', 11);
			$table->timestamps();
			$table->primary(['idSolicitud','idPlanta']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('detalleSolicitud');
	}

}
