<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company_product', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name',1000);
            $table->decimal('price', 16, 2);
            $table->decimal('cost_price', 16, 2);
            $table->decimal('market_price', 16, 2);
            $table->integer('sales_volume');
            $table->decimal('freight', 16, 2)->default(0.00);
            $table->integer('country_of_origin');
            $table->text('description');
            $table->text('activities_introduce');
            $table->integer('category');
            $table->integer('district');
            $table->decimal('rank');
            $table->decimal('evaluation');
            $table->string('image');
            $table->integer('company_id');
            $table->tinyInteger('recommend');
            $table->tinyInteger('advertise');
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
		Schema::drop('company_product');
	}

}
