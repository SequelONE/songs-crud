<?php

namespace SequelONE\SongsCRUD\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use SequelONE\SongsCRUD\app\Http\Requests\ArtistRequest;

class ArtistCrudController extends CrudController
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

    public function setup()
    {
        $this->crud->setModel("SequelONE\SongsCRUD\app\Models\Artist");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/songs/artists');
        $this->crud->setEntityNameStrings('artist', 'artists');
        //$this->crud->setFromDb();
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name'      => 'image', // The db column name
            'label'     => 'Image', // Table column heading
            'type'      => 'image',
            // 'prefix' => 'folder/subfolder/',
            // image from a different disk (like s3 bucket)
            // 'disk'   => 'disk-name',
            // optional width/height if 25px is not ok with you
            'height' => '100px',
            'width'  => '100px',
        ]);
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
        $this->crud->setValidation(ArtistRequest::class);

        $this->crud->addField([
            'name' => 'name',
            'label' => 'Name',
            'tab' => trans('songs-crud::songscrud.general'),
        ]);
        $this->crud->addField([
            'name' => 'image',
            'label' => 'Image',
            'type' => 'browse',
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
            'default'    => $this->getGenerateShortlink(),
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

    public function getGenerateShortlink() {

        $fields = $this->crud->getFields();
        $generate = 'small'; //$fields['shortlink']['generate'];
        $length = 4; //$fields['shortlink']['length'];

        $generator = [
            'global' => '0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'numeric' => '0123456789',
            'small' => 'abcdefghijklmnopqrstuvwxyz',
            'small_alphanumeric' => '0123456789abcdefghijklmnopqrstuvwxyz',
            'big' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'big_alphanumeric' => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'special' => '!@#$%^&*()',
        ];

        if(array_key_exists($generate, $generator))
        {
            $chars = $generator[$generate];
            return substr(str_shuffle($chars), 0, $length);
        }

        return false;
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
