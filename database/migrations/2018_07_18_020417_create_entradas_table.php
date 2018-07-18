<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEntradasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('entradas', function(Blueprint $table)
		{
			$table->integer('idEntrada', true);
			$table->integer('idSolicitud')->index('fk_entradas_solicitudes1_idx');
			$table->integer('user_id')->index('fk_entradas_user1_idx');
			$table->dateTime('fechaHora');
			$table->integer('cantidadTotal');
			$table->decimal('valorTotal', 11);
			$table->text('observacion', 65535)->nullable()->comment('ejemplo se entrega 50 limones y 30 naranjas');
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
		Schema::drop('entradas');
	}

}
