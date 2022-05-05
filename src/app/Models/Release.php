<?php

namespace SequelONE\SongsCRUD\app\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\Sluggable;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\SluggableScopeHelpers;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;

class Release extends Model
{
    use CrudTrait;
    use HasTranslations;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'songs';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = [
        'slug',
        'title',
        'description',
        'keywords',
        'htitle',
        'hsubtitle',
        'introtext',
        'content',
        'tracks',
        'image',
        'background',
        'apple_music',
        'itunes',
        'spotify',
        'youtube_music',
        'yandex_music',
        'vk_music',
        'amazon_music',
        'pandora',
        'deezer',
        'iheartradio',
        'napster',
        'tencent',
        'triller',
        'netease',
        'gaana',
        'joox',
        'tim',
        'wynk_hungama',
        'zed_plus',
        'qobuz',
        'peloton',
        'douyin',
        'medianet',
        'touchtunes',
        'vervelife',
        'tidal',
        'gracenote',
        'shazam',
        'yousee_musik',
        'kkbox',
        'music_island',
        'anghami',
        'claromusica',
        'zvooq',
        'jiosaavn',
        'qsic',
        'kuack',
        'boomplay_music',
        'musictime',
        'shortlink',
        'status',
        'genre_id',
        'featured',
        'date'
    ];

    protected $translatable = ['name', 'slug', 'introtext', 'content'];

    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'featured'  => 'boolean',
        'date'      => 'date',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function genre()
    {
        return $this->belongsTo('SequelONE\SongsCRUD\app\Models\Genre', 'genre_id');
    }

    public function types()
    {
        return $this->belongsToMany('SequelONE\SongsCRUD\app\Models\Type', 'songs_song_type');
    }

    public function labels()
    {
        return $this->belongsToMany('SequelONE\SongsCRUD\app\Models\Label', 'songs_song_label');
    }

    public function artists()
    {
        return $this->belongsToMany('SequelONE\SongsCRUD\app\Models\Artist', 'songs_song_artist');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED')
            ->where('date', '<=', date('Y-m-d'))
            ->orderBy('date', 'DESC');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "title" field if no slug exists.
    public function getSlugOrTitleAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->title;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
