<?php

use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

    public function up()
    {
        Schema::create('categories', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable()->default(NULL);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('categories');
    }

}
