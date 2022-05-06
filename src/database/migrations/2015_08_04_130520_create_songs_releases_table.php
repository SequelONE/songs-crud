<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSongsReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs_releases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image')->nullable();
            $table->string('background')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->text('keywords')->nullable();
            $table->string('htitle')->nullable();
            $table->string('hsubtitle')->nullable();
            $table->text('introtext')->nullable();
            $table->text('content')->nullable();
            $table->text('tracks')->nullable();
            $table->string('apple_music')->nullable();
            $table->string('itunes')->nullable();
            $table->string('spotify')->nullable();
            $table->string('youtube_music')->nullable();
            $table->string('yandex_music')->nullable();
            $table->string('vk_music')->nullable();
            $table->string('amazon_music')->nullable();
            $table->string('pandora')->nullable();
            $table->string('deezer')->nullable();
            $table->string('iheartradio')->nullable();
            $table->string('napster')->nullable();
            $table->string('tencent')->nullable();
            $table->string('triller')->nullable();
            $table->string('netease')->nullable();
            $table->string('gaana')->nullable();
            $table->string('joox')->nullable();
            $table->string('tim')->nullable();
            $table->string('wynk_hungama')->nullable();
            $table->string('zed_plus')->nullable();
            $table->string('qobuz')->nullable();
            $table->string('peloton')->nullable();
            $table->string('douyin')->nullable();
            $table->string('medianet')->nullable();
            $table->string('touchtunes')->nullable();
            $table->string('vervelife')->nullable();
            $table->string('tidal')->nullable();
            $table->string('gracenote')->nullable();
            $table->string('shazam')->nullable();
            $table->string('yousee_musik')->nullable();
            $table->string('kkbox')->nullable();
            $table->string('music_island')->nullable();
            $table->string('anghami')->nullable();
            $table->string('claromusica')->nullable();
            $table->string('zvooq')->nullable();
            $table->string('jiosaavn')->nullable();
            $table->string('qsic')->nullable();
            $table->string('kuack')->nullable();
            $table->string('boomplay_music')->nullable();
            $table->string('musictime')->nullable();
            $table->string('slug')->unique();
            $table->string('shortlink')->unique()->nullable();
            $table->integer('genre_id')->unsigned();
            $table->enum('status', ['PUBLISHED', 'DRAFT'])->default('PUBLISHED');
            $table->date('date');
            $table->boolean('featured')->default(0);
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
        Schema::drop('songs_releases');
    }
}
