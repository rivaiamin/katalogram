<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('slug', 10)->nullable();
            $table->string('name', 64);
            $table->string('logo', 128)->nullable();
            $table->string('picture', 128)->nullable();
            $table->string('quote', 128)->nullable();
            $table->text('desc')->nullable();
            $table->text('data')->nullable();
            $table->string('website', 64);
            $table->string('embed', 128)->nullable();
			$table->boolean('is_release')->default(1);

			$table->integer('view_count')->default(0);
            $table->decimal('rating_avg',5,2)->default(0);
            $table->integer('plus_count')->default(0);
            $table->integer('minus_count')->default(0);
            $table->integer('collect_count')->default(0);

			$table->softDeletes();
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

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
        Schema::drop('products');
    }
}
