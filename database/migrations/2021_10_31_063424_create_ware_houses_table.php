<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWareHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ware_houses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('images')->nullable();
            $table->string('import_price');
            $table->string('import_quantity');
            $table->string('inventory');
            $table->datetime('import_date');
            $table->integer('status');
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
        Schema::dropIfExists('ware_houses');
    }
}
