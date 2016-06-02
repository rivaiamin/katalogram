<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('fullname', 64);
            $table->integer('born')->unsigned();
            $table->string('cover', 128);
            $table->string('location', 128);
            $table->string('summary', 128);
            $table->text('profile');
            $table->timestamps();
        });

		Schema::table('user_profiles', function (Blueprint $table) {
			$table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::drop('user_profiles');
    }
}
