<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPlantasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('plantas', function(Blueprint $table)
		{
			$table->foreign('idTipoPlanta', 'fk_plantas_tipoPlanta1')->references('idTipoPlanta')->on('tipoPlanta')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('plantas', function(Blueprint $table)
		{
			$table->dropForeign('fk_plantas_tipoPlanta1');
		});
	}

}
