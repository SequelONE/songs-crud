<?php

/*
|--------------------------------------------------------------------------
| SequelONE\SongsCRUD Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the SequelONE\SongsCRUD package.
|
*/

Route::group([
    'namespace' => 'SequelONE\SongsCRUD\app\Http\Controllers\Admin',
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', 'admin'],
], function () {
    Route::crud('songs/releases', 'ReleaseCrudController');
    Route::crud('songs/types', 'TypeCrudController');
    Route::crud('songs/genres', 'GenreCrudController');
    Route::crud('songs/artists', 'ArtistCrudController');
    Route::crud('songs/labels', 'LabelCrudController');
    Route::crud('songs', 'TrackCrudController');

    Route::post('songs/create/track/add', [SequelONE\SongsCRUD\app\Http\Controllers\Admin\TrackController::class, 'upload']);
    Route::post('songs/create/track/remove', [SequelONE\SongsCRUD\app\Http\Controllers\Admin\TrackController::class, 'delete']);
    Route::post('songs/{id}/edit/track/add', [SequelONE\SongsCRUD\app\Http\Controllers\Admin\TrackController::class, 'upload']);
    Route::post('songs/{id}/edit/track/remove', [SequelONE\SongsCRUD\app\Http\Controllers\Admin\TrackController::class, 'delete']);
});
