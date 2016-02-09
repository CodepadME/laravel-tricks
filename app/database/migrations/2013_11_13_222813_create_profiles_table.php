<?php

use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('profiles', function ($table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->string('uid');
            $table->integer('user_id')->unsigned();
            $table->string('username')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('first_name')->nullable()->default(null);
            $table->string('last_name')->nullable()->default(null);
            $table->string('location')->nullable()->default(null);
            $table->string('description')->nullable()->default(null);
            $table->string('image_url')->nullable()->default(null);
            $table->string('access_token')->nullable()->default(null);
            $table->string('access_token_secret')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('profiles', function ($table) {
            $table->dropForeign('profiles_user_id_foreign');
        });

        Schema::drop('profiles');
    }
}
