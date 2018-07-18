<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAlmacenDatosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('almacenDatos', function(Blueprint $table)
		{
			$table->integer('idAlmacenDato', true);
			$table->integer('idSeccion')->index('fk_recoleccion_secciones1_idx');
			$table->string('tipo', 45)->comment('ENUM(\'humedad\',\'temperatura’)');
			$table->decimal('dato', 15);
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
		Schema::drop('almacenDatos');
	}

}
