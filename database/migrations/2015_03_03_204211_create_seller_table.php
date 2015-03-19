<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSellerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('seller', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name', 1000);
            $table->string('logo', 1000);
            $table->integer('district');
            $table->tinyInteger('type');
            $table->tinyInteger('card_type');
            $table->integer('category');
            $table->string('phone');
            $table->string('district_detail');
            $table->text('privilege');
            $table->text('introduce');
            $table->text('services');
            $table->decimal('latitude', 18, 8);
            $table->decimal('longitude', 18, 8);
            $table->string('geohash');
            $table->decimal('evaluation', 8, 1);
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
		Schema::drop('seller');
	}

}
