<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('level_id')->unsigned()->nullable();;
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 255);
            $table->integer('user_join')->unsigned()->nullable();
            $table->string('user_pict', 128)->nullable();
            $table->string('facebook', 128)->nullable();
            $table->string('google', 128)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('level_id')
                ->references('id')
                ->on('user_level')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
