<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEntradasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('entradas', function(Blueprint $table)
		{
			$table->foreign('idSolicitud', 'fk_entradas_solicitudes1')->references('idSolicitud')->on('solicitudes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id', 'fk_entradas_user1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('entradas', function(Blueprint $table)
		{
			$table->dropForeign('fk_entradas_solicitudes1');
			$table->dropForeign('fk_entradas_user1');
		});
	}

}
