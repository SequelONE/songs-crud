<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSongsTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs_tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('song_id')->default(0)->nullable();
            $table->string('name');
            $table->string('artist');
            $table->string('feat');
			$table->string('slug')->unique();
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
        Schema::drop('songs_tracks');
    }
}
