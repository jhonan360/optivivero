<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstadosSolicitudesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('estadosSolicitudes', function(Blueprint $table)
		{
			$table->integer('idEstadoSolicitud', true);
			$table->integer('idSolicitud')->index('fk_estadosSolicitudes_solicitudes1_idx');
			$table->string('estado', 45)->comment('ENUM(\'Enviado\',\'Recibido\',\'Leido\',\'Respondido\',\'Finalizado\')');
			$table->dateTime('fechaHora');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('estadosSolicitudes');
	}

}
