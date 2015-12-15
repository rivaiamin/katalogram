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
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name');
            $table->string('email')->unique();
            $table->string('password', 255);
            $table->integer('level_id')->unsigned();
            $table->integer('user_join')->unsigned();
            $table->string('user_pict', 128);
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
        Schema::drop('user');
    }
}
