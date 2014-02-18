<?php

use Illuminate\Database\Migrations\Migration;

class AddSpamToTricksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tricks', function($table)
		{
		    $table->boolean('spam')->default(0)->after('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tricks', function($table)
		{
		    $table->dropColumn('spam');
		});
	}

}
