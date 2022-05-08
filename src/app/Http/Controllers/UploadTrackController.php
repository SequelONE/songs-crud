<?php

namespace SequelONE\SongsCRUD\app\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Owenoj\LaravelGetId3\GetId3;
use SequelONE\SongsCRUD\app\Models\Track;

class UploadTrackController extends CrudController
{
    /**
     * @throws \getid3_exception
     */
    public function upload(Request $request)
    {
        if (!$request->has('file')) {
            return response()->json(['message' => 'Missing file'], 422);
        }

        $file = $request->file('file');

        $extension = !is_null($file->extension()) ? $file->extension() : 'mp3';
        $fileName = !is_null($file->getClientOriginalName()) ? rtrim($file->getClientOriginalName(), '.') : 'Unknown - Unknown.mp3';
        $tracksPath = 'public/tracks/';
        $globalPath = storage_path('app/public/tracks/');
        $globalTrackPath = $globalPath . $fileName;

        $file->move(storage_path('app/public/tracks'), $fileName);

        $fileHash = sha1_file($globalTrackPath);

        rename($globalTrackPath, $globalPath . $fileHash . '.' . $extension);

        $track = GetId3::fromDiskAndPath('storage', 'app/public/tracks/' . $fileHash . '.' . $extension);

        $t = $track->extractInfo();
        $title = !empty($t['tags']['id3v2']['title']['0']) ? $t['tags']['id3v2']['title']['0'] : 'Unknown';
        $artist = !empty($t['tags']['id3v2']['artist']['0']) ? $t['tags']['id3v2']['artist']['0'] : 'Unknown';
        $band = !empty($t['tags']['id3v2']['band']['0']) ? $t['tags']['id3v2']['band']['0'] : '';
        $album = !empty($t['tags']['id3v2']['album']['0']) ? $t['tags']['id3v2']['album']['0'] : '';
        $year = !empty($t['tags']['id3v2']['year']['0']) ? $t['tags']['id3v2']['year']['0'] : '';
        $genre = !empty($t['tags']['id3v2']['genre']['0']) ? $t['tags']['id3v2']['genre']['0'] : '';
        $url = Storage::url($tracksPath . $fileHash . '.mp3');

        if(!empty($track->getArtwork(true))) {
            $tmpCoverFile = $track->getArtwork(true)->getPathname();
            $coverPath = 'public/tracks/covers/';
            $cover64Path = 'cover.jpg';
            Storage::disk('local')->put($coverPath . '/' . $fileHash . '/' . $cover64Path, File::get($tmpCoverFile));

            $cover = Storage::url($coverPath . $fileHash . '/' . $cover64Path);
        } else {
            $cover = '/vendor/songs-crud/images/none.png';
        }

        DB::table('songs')->updateOrInsert(
            ['hash' => $fileHash],
            [
                'release_id' => $request->id,
                'image' => $cover,
                'name' => $title,
                'artist' => $artist,
                'band' => $band,
                'album' => $album,
                'year' => $year,
                'genre' => $genre,
                'url' => $url,
                'hash' => $fileHash,
                'sortable' => '',
                'slug' => $fileHash
            ]
        );

        $getTrackId = DB::table('songs')
            ->where('hash', $fileHash)
            ->where('release_id', $request->id)
            ->first();

        $id = !empty($getTrackId->id) ? $getTrackId->id : 1;

        $count = DB::table('songs')
            ->where('release_id', $request->id)
            ->count();

        $song = DB::table('songs')
            ->where('release_id', $request->id)
            ->first();

        $hash = $song->hash;

        if($count === 1) {
            $sortable = 0;
        } else {
            $sortable = $count - 1;
        }

        if($hash !== $fileHash) {
            DB::table('songs')->updateOrInsert(
                ['hash' => $fileHash],
                [
                    'sortable' => $sortable
                ]
            );
        }

        Session::put('release_id', $request->id);
        Session::put('hash', $fileHash);

        //return redirect()->route('trackEditJson', ['hash' => $fileHash]);

        return response()->json([
            'name' => $title,
            'artist' => $artist,
            'cover' => $cover,
            'band' => $band,
            'album' => $album,
            'year' => $year,
            'genre' => $genre,
            'hash' => $fileHash,
            'url' => $url,
            'sortable' => $sortable
        ]);
    }

    public function delete(Request $request): \Illuminate\Http\JsonResponse
    {
        $globalPath = storage_path('app/public/tracks/');



        Storage::delete([
            $globalPath . $request->name,
        ]);

        return response()->json([
            'success' => $request->name,
        ]);
    }

    /**
     * @throws \getid3_exception
     */
    public function getTrack(Request $request): \Illuminate\Http\JsonResponse
    {
        $sHash = Session::get('hash');
        $track = DB::table('songs')->where('hash', $sHash)->first();
        return response()->json([$track]);
    }

    /**
     * @throws \getid3_exception
     */
    public function getTracks(): \Illuminate\Http\JsonResponse
    {
        $sHash = Session::get('hash');
        $sReleaseId = Session::get('release_id');
        $tracks = DB::table('songs')->where('release_id', 4)->get();
        return response()->json([$tracks]);
    }
}
