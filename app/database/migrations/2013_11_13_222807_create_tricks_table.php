<?php

use Illuminate\Database\Migrations\Migration;

class CreateTricksTable extends Migration {

    public function up()
    {
        Schema::create('tricks', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->string('title', 140);
            $table->string('slug')->unique();
            $table->text('description')->nullable()->default(NULL);
            $table->text('code');
            $table->integer('vote_cache')->unsigned()->default(0);
            $table->integer('view_cache')->unsigned()->default(0);
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('tricks', function($table)
        {
            $table->dropForeign('tricks_user_id_foreign');
        });

        Schema::drop('tricks');
    }

}
