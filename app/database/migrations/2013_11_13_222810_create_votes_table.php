<?php

use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration {

    public function up()
    {
        Schema::create('votes', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('trick_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
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
        Schema::table('votes', function($table)
        {
            $table->dropForeign('votes_user_id_foreign');
            $table->dropForeign('votes_trick_id_foreign');
        });

        Schema::drop('votes');
    }

}
