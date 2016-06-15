<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
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
            $table->string('name')->unique();
            $table->string('email')->unique();
			$table->string('picture', 128);
            $table->string('password', 255);
            $table->string('facebook', 128)->nullable();
            $table->string('google', 128)->nullable();
            $table->integer('product_count')->default(0);
            $table->integer('collect_count')->default(0);
            $table->integer('contact_count')->default(0);
            $table->integer('connect_count')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

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
