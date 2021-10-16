<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('time')->comment('coupon quality');
            $table->integer('condition')->comment('1: %, 2: vnđ');
            $table->integer('status')->comment('0: UP, 1: DOWN, 3: SENT');
            $table->integer('number')->comment('amount reduced');
            $table->string('code');
            $table->integer('statusSendShow')->comment('1: send for customer, 2: show for customer');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
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
        Schema::dropIfExists('coupons');
    }
}
