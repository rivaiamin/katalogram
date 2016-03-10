<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_parent')->unsigned()->nullable();
            $table->string('category_name', 32);
            $table->text('category_desc')->nullable();
            $table->string('category_icon', 128)->nullable();
            $table->enum('category_type', array('B','P'));
            $table->string('category_color', 16)->nullable();
            $table->timestamps();

            $table->foreign('category_parent')
                ->references('id')
                ->on('category')
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
        Schema::drop('category');
    }
}
