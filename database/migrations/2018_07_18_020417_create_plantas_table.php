<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlantasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plantas', function(Blueprint $table)
		{
			$table->integer('idPlanta', true);
			$table->integer('idTipoPlanta')->index('fk_plantas_tipoPlanta1_idx');
			$table->string('nombre', 45);
			$table->integer('cantidad');
			$table->decimal('valor', 11);
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
		Schema::drop('plantas');
	}

}
