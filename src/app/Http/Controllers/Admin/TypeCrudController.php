<?php

namespace SequelONE\SongsCRUD\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use SequelONE\SongsCRUD\app\Http\Requests\TypeRequest;

class TypeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel("SequelONE\SongsCRUD\app\Models\Type");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/songs/types');
        $this->crud->setEntityNameStrings('type', 'types');
        $this->crud->setFromDb();
    }

    protected function setupListOperation()
    {
        CRUD::addColumn('name');
        CRUD::addColumn('slug');
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();

        CRUD::addColumn('created_at');
        CRUD::addColumn('updated_at');
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(TypeRequest::class);
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setValidation(TypeRequest::class);
    }
}
