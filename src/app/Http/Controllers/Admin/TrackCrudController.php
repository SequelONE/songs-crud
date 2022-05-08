<?php

namespace SequelONE\SongsCRUD\app\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SequelONE\SongsCRUD\app\Http\Requests\TrackRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Owenoj\LaravelGetId3\GetId3;
use SequelONE\SongsCRUD\app\Models\Track;

class TrackCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    public function setup()
    {
        $this->crud->setModel("SequelONE\SongsCRUD\app\Models\Track");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/songs');
        $this->crud->setEntityNameStrings('song', 'songs');
        //$this->crud->setFromDb();
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn('name');
        $this->crud->addColumn('slug');
        $this->crud->addColumn('shortlink');
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
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();

        $this->crud->addColumn('created_at');
        $this->crud->addColumn('updated_at');
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(TrackRequest::class);

        $this->crud->addField([
            'name' => 'name',
            'label' => 'Name',
            'tab' => trans('songs-crud::songscrud.general'),
        ]);
        $this->crud->addField([
            'name' => 'slug',
            'label' => 'Slug (URL)',
            'type' => 'text',
            'hint' => 'Will be automatically generated from your name, if left empty.',
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
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
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
