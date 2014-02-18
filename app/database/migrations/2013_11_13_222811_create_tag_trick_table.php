<?php

use Illuminate\Database\Migrations\Migration;

class CreateTagTrickTable extends Migration {

    public function up()
    {
        Schema::create('tag_trick', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('tag_id')->unsigned();
            $table->integer('trick_id')->unsigned();
            $table->timestamps();

            $table->foreign('tag_id')
                  ->references('id')->on('tags')
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
        Schema::table('tag_trick', function($table)
        {
            $table->dropForeign('tag_trick_tag_id_foreign');
            $table->dropForeign('tag_trick_trick_id_foreign');
        });

        Schema::drop('tag_trick');
    }

}
