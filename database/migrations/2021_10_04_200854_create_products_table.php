<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name');
            $table->string('images');
            $table->string('price');
            $table->integer('type_id')->nullable();
            $table->integer('description_id')->nullable();
            $table->text('content');
            $table->integer('status');
            $table->integer('quantity');
            $table->string('import_price');
            $table->integer('product_sold');
            $table->integer('ware_houses_id');
            $table->double('star_vote')->nullable();
            $table->integer('views');
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
        Schema::dropIfExists('products');
    }
}
