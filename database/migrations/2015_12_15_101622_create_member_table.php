<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->increments('id');
            $table->string('member_name', 64);
            $table->integer('member_born')->unsigned();
            $table->enum('member_gender', array('L', 'P'));
            $table->string('member_summary', 128);
            $table->text('member_profile');
            $table->string('member_website', 128);
            $table->enum('member_type', array('P', 'G'));
            $table->integer('member_category')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('member');
    }
}
