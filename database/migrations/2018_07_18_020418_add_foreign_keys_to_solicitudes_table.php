<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSolicitudesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('solicitudes', function(Blueprint $table)
		{
			$table->foreign('idProveedor', 'fk_solicitudes_proveedores1')->references('idProveedor')->on('proveedores')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id', 'fk_solicitudes_user1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('solicitudes', function(Blueprint $table)
		{
			$table->dropForeign('fk_solicitudes_proveedores1');
			$table->dropForeign('fk_solicitudes_user1');
		});
	}

}
