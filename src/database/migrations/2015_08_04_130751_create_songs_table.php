<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('release_id')->default(0)->nullable();
            $table->text('image')->nullable();
            $table->string('name')->nullable();
            $table->string('artist')->nullable();
            $table->string('band')->nullable();
            $table->string('album')->nullable();
            $table->string('year')->nullable();
            $table->string('genre')->nullable();
            $table->string('url')->nullable();
            $table->string('hash')->nullable();
            $table->integer('sortable')->default(0)->nullable();
            $table->string('shortlink')->unique()->nullable();
			$table->string('slug')->unique()->nullable();
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
        Schema::drop('songs');
    }
}
