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

    Route::post('songs/releases/create/track/add', [SequelONE\SongsCRUD\app\Http\Controllers\UploadTrackController::class, 'upload'])->name('trackCreateAdd');
    Route::post('songs/releases/create/track/remove', [SequelONE\SongsCRUD\app\Http\Controllers\UploadTrackController::class, 'delete'])->name('trackCreateDelete');
    Route::post('songs/releases/{id}/edit/track/add', [SequelONE\SongsCRUD\app\Http\Controllers\UploadTrackController::class, 'upload'])->name('trackEditAdd');
    Route::post('songs/releases/{id}/edit/track/remove', [SequelONE\SongsCRUD\app\Http\Controllers\UploadTrackController::class, 'delete'])->name('trackEditRemove');

    Route::post('songs/releases/json', [SequelONE\SongsCRUD\app\Http\Controllers\UploadTrackController::class, 'getTrack'])->name('trackEditJson');
    Route::get('songs/releases/json', [SequelONE\SongsCRUD\app\Http\Controllers\UploadTrackController::class, 'getTrack']);
    Route::get('songs/releases/json/all', [SequelONE\SongsCRUD\app\Http\Controllers\UploadTrackController::class, 'getTracks'])->name('tracksEditJson');
});
