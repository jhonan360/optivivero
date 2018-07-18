<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalidasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('salidas', function(Blueprint $table)
		{
			$table->integer('idSalidas', true);
			$table->integer('user_id')->index('fk_salidas_user1_idx');
			$table->dateTime('fechaHora');
			$table->integer('cantidadTotal');
			$table->decimal('valorTotal', 11);
			$table->text('observacion', 65535)->nullable();
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
		Schema::drop('salidas');
	}

}
