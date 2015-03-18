<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdvertiseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('advertise', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('logo');
            $table->integer('company_id');
            $table->text('introduce');
            $table->text('detail');
            $table->string('url');
            $table->tinyInteger('recommend');
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
		Schema::drop('advertise');
	}

}
