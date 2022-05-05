<?php

namespace SequelONE\SongsCRUD\app\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Type extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'songscrud:types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all databases';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = [
            ['id' => 1, 'name' => '{"ru":"Сингл", "en":"Single", "de":"Single"}', 'slug' => '{"ru":"single", "en":"single", "de":"single"}'],
            ['id' => 2, 'name' => '{"ru":"Альбом", "en":"Album", "de":"Album"}', 'slug' => '{"ru":"album", "en":"album", "de":"album"}'],
            ['id' => 3, 'name' => '{"ru":"Микстейп", "en":"Mixtape", "de":"Mixtape"}', 'slug' => '{"ru":"mixtape", "en":"mixtape", "de":"mixtape"}'],
            ['id' => 4, 'name' => '{"ru":"EP", "en":"EP", "de":"EP"}', 'slug' => '{"ru":"ep", "en":"ep", "de":"ep"}'],
            ['id' => 5, 'name' => '{"ru":"LP", "en":"LP", "de":"LP"}', 'slug' => '{"ru":"lp", "en":"lp", "de":"lp"}']
        ];

        foreach($data as $d) {
            $id = $d['id'];
            $name = $d['name'];
            $slug = $d['slug'];

            DB::table('songs_types')->updateOrInsert(
                ['id' => $id],
                [
                    'id' => $id,
                    'name' => $name,
                    'slug' => $slug
                ]
            );
        }

        $countDBTypes = DB::table('songs_types')->count();

        $this->line('=======================================================');
        $this->line('Updated entries: ' . $countDBTypes);
        $this->line('=======================================================');

        $this->info('Added or updated (' . $countDBTypes . ') records in the database!');
    }

}
