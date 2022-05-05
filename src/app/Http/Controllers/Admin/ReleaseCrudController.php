<?php

namespace SequelONE\SongsCRUD\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use SequelONE\SongsCRUD\app\Http\Requests\ReleaseRequest;

class ReleaseCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel(\SequelONE\SongsCRUD\app\Models\Release::class);
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/songs/releases');
        $this->crud->setEntityNameStrings('release', 'releases');

        /*
        |--------------------------------------------------------------------------
        | LIST OPERATION
        |--------------------------------------------------------------------------
        */
        $this->crud->operation('list', function () {
            $this->crud->addColumn([
                'name'      => 'image', // The db column name
                'label'     => trans('songs-crud::songscrud.cover'), // Table column heading
                'type'      => 'image',
                // 'prefix' => 'folder/subfolder/',
                // image from a different disk (like s3 bucket)
                // 'disk'   => 'disk-name',
                // optional width/height if 25px is not ok with you
                'height' => '100px',
                'width'  => '100px',
            ]);
            $this->crud->addColumn([
                'name' => 'title',
                'label' => trans('songs-crud::songscrud.title'),
                'type' => 'text',
            ]);
            $this->crud->addColumn([
                'name' => 'date',
                'label' => trans('songs-crud::songscrud.date'),
                'type' => 'date',
            ]);
            //$this->crud->addColumn('status');
            $this->crud->addColumn([
                'name' => 'featured',
                'label' => trans('songs-crud::songscrud.featured'),
                'type' => 'check',
            ]);
            $this->crud->addColumn([
                'label' => trans('songs-crud::songscrud.genres'),
                'type' => 'select',
                'name' => 'genre_id',
                'entity' => 'genre',
                'attribute' => 'name',
                'wrapper'   => [
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('songs/genres/'.$related_key.'/show');
                    },
                ],
            ]);
            $this->crud->addColumn([
                'label' => trans('songs-crud::songscrud.artists'),
                'type' => 'select',
                'name' => 'artists',
                'entity' => 'artists',
                'attribute' => 'name',
                'wrapper'   => [
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('songs/artists/'.$related_key.'/show');
                    },
                ],
            ]);
            $this->crud->addColumn([
                'label' => trans('songs-crud::songscrud.types'),
                'type' => 'select',
                'name' => 'types',
                'entity' => 'types',
                'attribute' => 'name',
                'wrapper'   => [
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('songs/types/'.$related_key.'/show');
                    },
                ],
            ]);

            $this->crud->addColumn([
                'label' => trans('songs-crud::songscrud.labels'),
                'type' => 'select',
                'name' => 'labels',
                'entity' => 'labels',
                'attribute' => 'name',
                'wrapper'   => [
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('songs/labels/'.$related_key.'/show');
                    },
                ],
            ]);

            $this->crud->addFilter([ // select2 filter
                'name' => 'genre_id',
                'type' => 'select2',
                'label'=> trans('songs-crud::songscrud.genres'),
            ], function () {
                return \SequelONE\SongsCRUD\app\Models\Genre::all()->keyBy('id')->pluck('name', 'id')->toArray();
            }, function ($value) { // if the filter is active
                $this->crud->addClause('where', 'genre_id', $value);
            });

            $this->crud->addFilter([ // select2_multiple filter
                'name' => 'artists',
                'type' => 'select2_multiple',
                'label'=> trans('songs-crud::songscrud.artists'),
            ], function () {
                return \SequelONE\SongsCRUD\app\Models\Artist::all()->keyBy('id')->pluck('name', 'id')->toArray();
            }, function ($values) { // if the filter is active
                $this->crud->query = $this->crud->query->whereHas('artists', function ($q) use ($values) {
                    foreach (json_decode($values) as $key => $value) {
                        if ($key == 0) {
                            $q->where('songs_artists.id', $value);
                        } else {
                            $q->orWhere('songs_artists.id', $value);
                        }
                    }
                });
            });

            $this->crud->addFilter([ // select2_multiple filter
                'name' => 'types',
                'type' => 'select2_multiple',
                'label'=> trans('songs-crud::songscrud.types'),
            ], function () {
                return \SequelONE\SongsCRUD\app\Models\Type::all()->keyBy('id')->pluck('name', 'id')->toArray();
            }, function ($values) { // if the filter is active
                $this->crud->query = $this->crud->query->whereHas('types', function ($q) use ($values) {
                    foreach (json_decode($values) as $key => $value) {
                        if ($key == 0) {
                            $q->where('songs_types.id', $value);
                        } else {
                            $q->orWhere('songs_types.id', $value);
                        }
                    }
                });
            });

            $this->crud->addFilter([ // select2_multiple filter
                'name' => 'labels',
                'type' => 'select2_multiple',
                'label'=> trans('songs-crud::songscrud.labels'),
            ], function () {
                return \SequelONE\SongsCRUD\app\Models\Label::all()->keyBy('id')->pluck('name', 'id')->toArray();
            }, function ($values) { // if the filter is active
                $this->crud->query = $this->crud->query->whereHas('labels', function ($q) use ($values) {
                    foreach (json_decode($values) as $key => $value) {
                        if ($key == 0) {
                            $q->where('songs_labels.id', $value);
                        } else {
                            $q->orWhere('songs_labels.id', $value);
                        }
                    }
                });
            });
        });

        /*
        |--------------------------------------------------------------------------
        | CREATE & UPDATE OPERATIONS
        |--------------------------------------------------------------------------
        */
        $this->crud->operation(['create', 'update'], function () {
            $this->crud->setValidation(ReleaseRequest::class);

            $this->crud->addField([
                'name' => 'title',
                'label' => trans('songs-crud::songscrud.title'),
                'type' => 'text',
                'tab' => trans('songs-crud::songscrud.general'),
                'placeholder' => trans('songs-crud::songscrud.placeholder.title'),
                'hint' => trans('songs-crud::songscrud.hint.title'),
            ]);
            $this->crud->addField([
                'name' => 'description',
                'label' => trans('songs-crud::songscrud.description'),
                'type' => 'textarea',
                'tab' => trans('songs-crud::songscrud.general'),
            ]);
            $this->crud->addField([
                'name' => 'htitle',
                'label' => trans('songs-crud::songscrud.htitle'),
                'type' => 'text',
                'tab' => trans('songs-crud::songscrud.general'),
            ]);
            $this->crud->addField([
                'name' => 'hsubtitle',
                'label' => trans('songs-crud::songscrud.hsubtitle'),
                'type' => 'text',
                'tab' => trans('songs-crud::songscrud.general'),
            ]);
            $this->crud->addField([
                'name' => 'slug',
                'label' => trans('songs-crud::songscrud.slug'),
                'type' => 'text',
                'hint' => trans('songs-crud::songscrud.hint.slug'),
                // 'disabled' => 'disabled'
                'tab' => trans('songs-crud::songscrud.general'),
            ]);
            $this->crud->addField([
                'name' => 'shortlink',
                'label' => trans('songs-crud::songscrud.shortlink'),
                'type' => 'shortlink',
                'generate' => 'small',
                'length' => 4,
                'tab' => trans('songs-crud::songscrud.general'),
            ]);
            $this->crud->addField([
                'name' => 'date',
                'label' => trans('songs-crud::songscrud.date'),
                'type' => 'date',
                'default' => date('Y-m-d'),
                'tab' => trans('songs-crud::songscrud.general'),
            ]);
            $this->crud->addField([
                'name' => 'introtext',
                'label' => trans('songs-crud::songscrud.introtext'),
                'type' => 'ckeditor',
                'tab' => trans('songs-crud::songscrud.general'),
            ]);
            $this->crud->addField([
                'name' => 'content',
                'label' => trans('songs-crud::songscrud.content'),
                'type' => 'ckeditor',
                'tab' => trans('songs-crud::songscrud.general'),
            ]);
            $this->crud->addField([
                'name' => 'image',
                'label' => trans('songs-crud::songscrud.image'),
                'type' => 'browse',
                'tab' => trans('songs-crud::songscrud.general'),
            ]);
            $this->crud->addField([
                'name' => 'background',
                'label' => trans('songs-crud::songscrud.background'),
                'type' => 'browse',
                'tab' => trans('songs-crud::songscrud.general'),
            ]);
            $this->crud->addField([
                'label' => trans('songs-crud::songscrud.genre'),
                'type' => 'relationship',
                'name' => 'genre_id',
                'entity' => 'genre',
                'attribute' => 'name',
                'inline_create' => [
                    'entity' => 'genres',
                    'force_select' => true, // should the inline-created entry be immediately selected?
                    'modal_class' => 'modal-dialog modal-xl', // use modal-sm, modal-lg to change width
                    'modal_route' => route('songs/genres-inline-create'), // InlineCreate::getInlineCreateModal()
                    'create_route' =>  route('songs/genres-inline-create-save'), // InlineCreate::storeInlineCreate()
                ],
                'ajax' => true,
                'tab' => trans('songs-crud::songscrud.filters'),
            ]);
            $this->crud->addField([
                'label' => trans('songs-crud::songscrud.artists'),
                'type' => 'relationship',
                'name' => 'artists', // the method that defines the relationship in your Model
                'entity' => 'artists', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                /*'inline_create' => [
                    'entity' => 'artists',
                    'force_select' => true, // should the inline-created entry be immediately selected?
                    'modal_class' => 'modal-dialog modal-xl', // use modal-sm, modal-lg to change width
                    'modal_route' => route('songs/artists-inline-create'), // InlineCreate::getInlineCreateModal()
                    'create_route' =>  route('songs/artists-inline-create-save'), // InlineCreate::storeInlineCreate()
                ],*/
                'ajax' => true,
                'tab' => trans('songs-crud::songscrud.filters'),
            ]);
            $this->crud->addField([
                'label' => trans('songs-crud::songscrud.types'),
                'type' => 'relationship',
                'name' => 'types', // the method that defines the relationship in your Model
                'entity' => 'types', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                'inline_create' => [
                    'entity' => 'types',
                    'force_select' => true, // should the inline-created entry be immediately selected?
                    'modal_class' => 'modal-dialog modal-xl', // use modal-sm, modal-lg to change width
                    'add_button_label' => trans('songs-crud::songscrud.add'),
                    'modal_route' => route('songs/types-inline-create'), // InlineCreate::getInlineCreateModal()
                    'create_route' =>  route('songs/types-inline-create-save'), // InlineCreate::storeInlineCreate()
                ],
                'ajax' => true,
                'tab' => trans('songs-crud::songscrud.filters'),
            ]);
            $this->crud->addField([
                'label' => trans('songs-crud::songscrud.labels'),
                'type' => 'relationship',
                'name' => 'labels', // the method that defines the relationship in your Model
                'entity' => 'labels', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                'inline_create' => [
                    'entity' => 'labels',
                    'force_select' => true, // should the inline-created entry be immediately selected?
                    'modal_class' => 'modal-dialog modal-xl', // use modal-sm, modal-lg to change width
                    'modal_route' => route('songs/labels-inline-create'), // InlineCreate::getInlineCreateModal()
                    'create_route' =>  route('songs/labels-inline-create-save'), // InlineCreate::storeInlineCreate()
                ],
                'ajax' => true,
                'tab' => trans('songs-crud::songscrud.filters'),
            ]);
            $this->crud->addField([
                'name' => 'apple_music',
                'label' => 'Apple Music',
                'type' => 'text',
                'placeholder' => 'Link on Apple Music',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'itunes',
                'label' => 'iTunes',
                'type' => 'text',
                'placeholder' => 'Link on iTunes',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'spotify',
                'label' => 'Spotify',
                'type' => 'text',
                'placeholder' => 'Link on Spotify',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'youtube_music',
                'label' => 'Youtube Music',
                'type' => 'text',
                'placeholder' => 'Link on Youtube Music',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'yandex_music',
                'label' => 'Yandex.Music',
                'type' => 'text',
                'placeholder' => 'Link on Yandex.Music',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'vk_music',
                'label' => 'VK Music',
                'type' => 'text',
                'placeholder' => 'Link on VK Music',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'amazon_music',
                'label' => 'Amazon Music',
                'type' => 'text',
                'placeholder' => 'Link on Amazon Music',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'pandora',
                'label' => 'Pandora',
                'type' => 'text',
                'placeholder' => 'Link on Pandora',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'deezer',
                'label' => 'Deezer',
                'type' => 'text',
                'placeholder' => 'Link on Deezer',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'iheartradio',
                'label' => 'iHeartRadio',
                'type' => 'text',
                'placeholder' => 'Link on iHeartRadio',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'napster',
                'label' => 'Napster',
                'type' => 'text',
                'placeholder' => 'Link on Napster',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'tencent',
                'label' => 'Tencent',
                'type' => 'text',
                'placeholder' => 'Link on Tencent',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'triller',
                'label' => 'Triller/7Digital',
                'type' => 'text',
                'placeholder' => 'Link on Triller/7Digital',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'netease',
                'label' => 'NetEase',
                'type' => 'text',
                'placeholder' => 'Link on NetEase',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'gaana',
                'label' => 'Gaana',
                'type' => 'text',
                'placeholder' => 'Link on Gaana',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'joox',
                'label' => 'Joox',
                'type' => 'text',
                'placeholder' => 'Link on Joox',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'tim',
                'label' => 'TIM',
                'type' => 'text',
                'placeholder' => 'Link on TIM',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'wynk_hungam',
                'label' => 'Wynk/Hungama',
                'type' => 'text',
                'placeholder' => 'Link on Wynk/Hungama',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'zed_plus',
                'label' => 'Zed+',
                'type' => 'text',
                'placeholder' => 'Link on Zed+',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'qobuz',
                'label' => 'Qobuz',
                'type' => 'text',
                'placeholder' => 'Link on Qobuz',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'peloton',
                'label' => 'Peloton',
                'type' => 'text',
                'placeholder' => 'Link on Peloton',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'douyin',
                'label' => 'Douyin',
                'type' => 'text',
                'placeholder' => 'Link on Douyin',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'medianet',
                'label' => 'MediaNet',
                'type' => 'text',
                'placeholder' => 'Link on MediaNet',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'touchtunes',
                'label' => 'TouchTunes/PlayNetwork',
                'type' => 'text',
                'placeholder' => 'Link on TouchTunes/PlayNetwork',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'vervelife',
                'label' => 'VerveLife',
                'type' => 'text',
                'placeholder' => 'Link on VerveLife',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'tidal',
                'label' => 'Tidal',
                'type' => 'text',
                'placeholder' => 'Link on Tidal',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'gracenote',
                'label' => 'Gracenote',
                'type' => 'text',
                'placeholder' => 'Link on Gracenote',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'shazam',
                'label' => 'Shazam',
                'type' => 'text',
                'placeholder' => 'Link on Shazam',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'yousee_music',
                'label' => 'YouSee Musik / Telmore Musik',
                'type' => 'text',
                'placeholder' => 'Link on YouSee Musik / Telmore Musik',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'kkbox',
                'label' => 'KKBox',
                'type' => 'text',
                'placeholder' => 'Link on KKBox',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'music_island',
                'label' => 'Music Island',
                'type' => 'text',
                'placeholder' => 'Link on Music Island',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'anghami',
                'label' => 'Anghami',
                'type' => 'text',
                'placeholder' => 'Link on Anghami',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'claromusica',
                'label' => 'ClaroMusica',
                'type' => 'text',
                'placeholder' => 'Link on ClaroMusica',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'zvooq',
                'label' => 'Zvooq',
                'type' => 'text',
                'placeholder' => 'Link on Zvooq',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'jiosaavn',
                'label' => 'JioSaavn',
                'type' => 'text',
                'placeholder' => 'Link on JioSaavn',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'qsic',
                'label' => 'Q.Sic',
                'type' => 'text',
                'placeholder' => 'Link on Q.Sic',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'kuack',
                'label' => 'Kuack',
                'type' => 'text',
                'placeholder' => 'Link on Kuack',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'boomplay_music',
                'label' => 'Boomplay Music',
                'type' => 'text',
                'placeholder' => 'Link on Boomplay Music',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'musictime',
                'label' => 'MusicTime',
                'type' => 'text',
                'placeholder' => 'Link on MusicTime',
                'tab' => trans('songs-crud::songscrud.platforms'),
            ]);
            $this->crud->addField([
                'name' => 'status',
                'label' => trans('songs-crud::songscrud.status'),
                'type' => 'select_from_array',
                'options' => ['PUBLISHED', 'DRAFT'],
                'tab' => trans('songs-crud::songscrud.general'),
            ]);
            $this->crud->addField([
                'name' => 'featured',
                'label' => trans('songs-crud::songscrud.featured'),
                'type' => 'checkbox',
                'tab' => trans('songs-crud::songscrud.general'),
            ]);
            $this->crud->addField([   // Table
                'name'            => 'tracks',
                'label'           => trans('songs-crud::songscrud.tracks'),
                'type'            => 'table',
                'entity_singular' => trans('songs-crud::songscrud.table.track'),
                'columns'         => [
                    'name'  => trans('songs-crud::songscrud.table.song'),
                    'artist'  => trans('songs-crud::songscrud.table.artist'),
                    'feat'  => trans('songs-crud::songscrud.table.feat'),
                    'time'  => trans('songs-crud::songscrud.table.time'),
                ],
                'max' => 50, // maximum rows allowed in the table
                'min' => 0, // minimum rows allowed in the table
                'tab' => trans('songs-crud::songscrud.tracks'),
            ]);
            $this->crud->addField([
                'name' => 'songs',
                'label' => trans('songs-crud::songscrud.upload_tracks'),
                'type' => 'songs',
                'disk'             => 'public',
                'destination_path' => 'products/',
                'image_width'      => 800,
                'image_height'     => 600,
                'mimes'            => 'image/*',
                'max_file_size'    => 25, // MB
                'thumb_prefix'     => '',
                'tab' => trans('songs-crud::songscrud.tracks'),
            ]);
        });
    }

    /**
     * Respond to AJAX calls from the select2 with entries from the Genre model.
     *
     * @return JSON
     */
    public function fetchGenre()
    {
        return $this->fetch(\SequelONE\SongsCRUD\app\Models\Genre::class);
    }

    /**
     * Respond to AJAX calls from the select2 with entries from the Tag model.
     *
     * @return JSON
     */
    public function fetchArtists()
    {
        return $this->fetch(\SequelONE\SongsCRUD\app\Models\Artist::class);
    }

    /**
     * Respond to AJAX calls from the select2 with entries from the Tag model.
     *
     * @return JSON
     */
    public function fetchTypes()
    {
        return $this->fetch(\SequelONE\SongsCRUD\app\Models\Type::class);
    }

    /**
     * Respond to AJAX calls from the select2 with entries from the Tag model.
     *
     * @return JSON
     */
    public function fetchLabels()
    {
        return $this->fetch(\SequelONE\SongsCRUD\app\Models\Label::class);
    }
}
