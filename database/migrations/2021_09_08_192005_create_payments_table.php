<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('customer_id');
            $table->string('total_money')->comment('Số Tiền');
            $table->string('vnp_response',255)->comment('Trạng thái（00: Thành Công, 01: Thất Bại)');
            $table->string('code_vnpay',255)->comment('Mã giao dịch');
            $table->string('code_back',255)->comment('Mã ngân hàng');
            $table->string('time',255)->comment('Thời Gian');
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
        Schema::dropIfExists('payments');
    }
}
