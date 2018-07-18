<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSolicitudesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('solicitudes', function(Blueprint $table)
		{
			$table->integer('idSolicitud', true);
			$table->integer('idProveedor')->index('fk_solicitudes_proveedores1_idx');
			$table->integer('user_id')->index('fk_solicitudes_user1_idx');
			$table->string('nombre', 200);
			$table->dateTime('fechaHora');
			$table->integer('cantidadTotal');
			$table->decimal('valorTotal', 11);
			$table->text('obervacion1', 65535)->nullable();
			$table->text('observacion2', 65535)->nullable();
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
		Schema::drop('solicitudes');
	}

}
