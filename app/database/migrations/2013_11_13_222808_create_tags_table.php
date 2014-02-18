<?php

use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration {

    public function up()
    {
        Schema::create('tags', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('user_id')->unsigned()->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('tags', function($table)
        {
            $table->dropForeign('tags_user_id_foreign');
        });
        Schema::drop('tags');
    }

}
