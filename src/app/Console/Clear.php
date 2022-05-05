<?php

namespace SequelONE\SongsCRUD\app\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Clear extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'songscrud:clear';

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
        DB::table('songs_types')->truncate();
        DB::table('songs_genres')->truncate();

        $this->info('Congratulations! The tables are completely cleared!');
    }

}
