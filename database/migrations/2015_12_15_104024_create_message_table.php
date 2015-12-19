<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('message_parent')->unsigned();
            $table->integer('message_sender')->unsigned();
            $table->integer('message_recipient')->unsigned();
            $table->text('message_content');
            $table->integer('message_time')->unsigned();
            $table->integer('message_read')->unsigned();
            $table->timestamps();

            $table->foreign('message_parent')
                ->references('id')
                ->on('message')
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
        Schema::drop('message');
    }
}
