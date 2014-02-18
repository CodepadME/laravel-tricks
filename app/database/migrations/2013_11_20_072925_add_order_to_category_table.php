<?php

use Illuminate\Database\Migrations\Migration;

class AddOrderToCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('categories', function($table)
		{
		    $table->integer('order')->unsigned()->after('description');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('categories', function($table)
		{
		    $table->dropColumn('order');
		});
	}

}
