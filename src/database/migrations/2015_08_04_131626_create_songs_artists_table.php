<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSongsArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs_artists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->text('keywords');
            $table->string('htitle')->nullable();
            $table->string('hsubtitle')->nullable();
            $table->text('introtext');
            $table->text('content');
            $table->string('slug')->unique();
            $table->string('shortlink')->unique()->nullable();
            $table->string('vk')->nullable();
            $table->string('fb')->nullable();
            $table->string('ig')->nullable();
            $table->string('tg')->nullable();
            $table->string('tt')->nullable();
            $table->string('tw')->nullable();
            $table->string('yt')->nullable();
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
        Schema::drop('songs_artists');
    }
}
