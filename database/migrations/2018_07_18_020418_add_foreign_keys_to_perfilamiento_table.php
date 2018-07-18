<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPerfilamientoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('perfilamiento', function(Blueprint $table)
		{
			$table->foreign('user_id', 'fk_perfilamiento_user')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('perfilamiento', function(Blueprint $table)
		{
			$table->dropForeign('fk_perfilamiento_user');
		});
	}

}
