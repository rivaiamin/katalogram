<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('product_code', 10)->nullable();
            $table->string('product_name', 64);
            $table->string('product_logo', 128)->nullable();
            $table->string('product_quote', 128)->nullable();
            $table->text('product_desc')->nullable();
            $table->text('product_data')->nullable();
            $table->string('product_website', 64);
            $table->integer('product_release')->unsigned()->nullable();
            $table->integer('product_view')->unsigned()->nullable();
            $table->string('product_embed', 128)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('category')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('user')
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
        Schema::drop('product');
    }
}
