<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('photo_id');
            $table->integer('publish_time');
            $table->string('flickr_photo_id', 45);
            $table->string('flickr_tags')->default('');
            $table->text('flickr_groups');
            $table->boolean('status')->default(false);
            $table->string('auth_token');
            $table->string('auth_secret');
            $table->string('url')->default('');


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
        Schema::dropIfExists('photos');
    }
}
