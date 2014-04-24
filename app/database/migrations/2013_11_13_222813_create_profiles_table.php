<?php

use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration {

    public function up()
    {
        Schema::create('profiles', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->string('uid');
            $table->integer('user_id')->unsigned();
            $table->string('username')->nullable()->default(NULL);
            $table->string('name')->nullable()->default(NULL);
            $table->string('email')->nullable()->default(NULL);
            $table->string('first_name')->nullable()->default(NULL);
            $table->string('last_name')->nullable()->default(NULL);
            $table->string('location')->nullable()->default(NULL);
            $table->string('description')->nullable()->default(NULL);
            $table->string('image_url')->nullable()->default(NULL);
            $table->string('access_token')->nullable()->default(NULL);
            $table->string('access_token_secret')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('profiles', function($table)
        {
            $table->dropForeign('profiles_user_id_foreign');
        });

        Schema::drop('profiles');
    }

}
