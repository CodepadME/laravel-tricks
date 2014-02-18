<?php

use Illuminate\Database\Migrations\Migration;

class CreateCategoryTrickTable extends Migration {

    public function up()
    {
        Schema::create('category_trick', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('trick_id')->unsigned();
            $table->timestamps();

            $table->foreign('category_id')
                  ->references('id')->on('categories')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('trick_id')
                  ->references('id')->on('tricks')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('category_trick', function($table)
        {
            $table->dropForeign('category_trick_category_id_foreign');
            $table->dropForeign('category_trick_trick_id_foreign');
        });
        Schema::drop('category_trick');
    }

}
