<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisplaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('displays', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('keyword', 255)->nullable();
            //header
            $table->integer('background_color')->nullable();
            $table->integer('text_color')->nullable();
            $table->string('header_logo', 255)->nullable();
            $table->integer('header_background_color')->nullable();
            $table->integer('header_opacity')->nullable();
            $table->integer('header_text_color')->nullable();
            $table->string('header_email', 255)->nullable();
            $table->integer('header_phone')->nullable();
            $table->string('header_social_image_1', 255)->nullable();
            $table->string('header_social_url_1', 255)->nullable();
            $table->string('header_social_image_2', 255)->nullable();
            $table->string('header_social_url_2', 255)->nullable();
            $table->string('header_social_image_3', 255)->nullable();
            $table->string('header_social_url_3', 255)->nullable();
            //input search
            $table->integer('search_border_radius')->nullable();
            $table->string('search_background_color', 255)->nullable();
            $table->string('search_frame_color', 255)->nullable();
            //button search
            $table->string('button_search_background_color', 255)->nullable();
            $table->string('button_search_frame_color', 255)->nullable();
            $table->string('button_search_color', 255)->nullable();

            //navbar
            $table->string('navbar_background_color', 255)->nullable();
            $table->string('navbar_color', 255)->nullable();

            //partner
            $table->string('partner_background_color', 255)->nullable();
            $table->string('partner_logo_1', 255)->nullable();
            $table->string('partner_logo_2', 255)->nullable();
            $table->string('partner_logo_3', 255)->nullable();
            $table->string('partner_logo_4', 255)->nullable();
            $table->string('partner_logo_5', 255)->nullable();

            //footer
            $table->string('footer_background_color')->nullable();
            //text 1
            $table->string('text_color_1')->nullable();
            $table->string('address', 255)->nullable();
            $table->integer('phone')->nullable();
            $table->string('email', 255)->nullable();

            //text 2
            $table->string('text_color_2')->nullable();
            $table->string('content_2_1', 255)->nullable();
            $table->string('url_2_1', 255)->nullable();
            $table->string('content_2_2', 255)->nullable();
            $table->string('url_2_2', 255)->nullable();
            $table->string('content_2_3', 255)->nullable();
            $table->string('url_2_3', 255)->nullable();
            $table->string('content_2_4', 255)->nullable();
            $table->string('url_2_4', 255)->nullable();
            //text 3
            $table->string('text_color_3')->nullable();
            $table->string('content_3_1', 255)->nullable();
            $table->string('url_3_1', 255)->nullable();
            $table->string('content_3_2', 255)->nullable();
            $table->string('url_3_2', 255)->nullable();
            $table->string('content_3_3', 255)->nullable();
            $table->string('url_3_3', 255)->nullable();
            $table->string('content_3_4', 255)->nullable();
            $table->string('url_3_4', 255)->nullable();
            //text 4
            $table->string('text_color_4')->nullable();
            $table->string('content_4_1', 255)->nullable();
            $table->integer('send_border_radius')->nullable();
            $table->string('send_background_color', 255)->nullable();
            $table->string('send_frame_color', 255)->nullable();
            $table->string('button_send_background_color', 255)->nullable();
            $table->string('button_send_frame_color', 255)->nullable();
            $table->string('button_send_color', 255)->nullable();
            //copyright
            $table->string('copyright-text_color', 255)->nullable();
            $table->string('copyright-text_left', 255)->nullable();
            $table->string('copyright-text_right', 255)->nullable();
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
        Schema::dropIfExists('displays');
    }
}
