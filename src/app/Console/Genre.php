<?php

namespace SequelONE\SongsCRUD\app\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Genre extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'songscrud:genres';

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
            ['id' => 1, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => 1, 'name' => '{"ru":"Поп", "en":"Pop", "de":"Pop"}', 'slug' => '{"ru":"pop", "en":"pop", "de":"pop"}'],
            ['id' => 2, 'parent_id' => 1, 'lft' => NULL, 'rgt' => NULL, 'depth' => 2, 'name' => '{"ru":"Фолк", "en":"Folk", "de":"Folk"}', 'slug' => '{"ru":"folk", "en":"folk", "de":"folk"}'],
            ['id' => 3, 'parent_id' => 2, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Этническая музыка", "en":"Ethnic music", "de":"Ethnische Musik"}', 'slug' => '{"ru":"etnicheskaya-muzyka", "en":"ethnic-music", "de":"ethnische-musik"}'],
            ['id' => 4, 'parent_id' => 2, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Прогрессив-фолк", "en":"Progressive folk", "de":"Progressive Folk"}', 'slug' => '{"ru":"progressiv-folk", "en":"progressive-folk", "de":"progressive-folk"}'],
            ['id' => 5, 'parent_id' => 2, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Фолк-барок", "en":"Folk-Baroque", "de":"Folk-Barock"}', 'slug' => '{"ru":"folk-barok", "en":"folk-baroque", "de":"folk-barock"}'],
            ['id' => 6, 'parent_id' => 2, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Филк", "en":"Filk", "de":"Filk"}', 'slug' => '{"ru":"filk", "en":"filk", "de":"filk"}'],
            ['id' => 7, 'parent_id' => 1, 'lft' => NULL, 'rgt' => NULL, 'depth' => 2, 'name' => '{"ru":"Кантри", "en":"Country", "de":"Country"}', 'slug' => '{"ru":"kantry", "en":"country", "de":"country"}'],
            ['id' => 8, 'parent_id' => 7, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Блюграсс", "en":"Bluegrass", "de":"Bluegrass"}', 'slug' => '{"ru":"blyugrass", "en":"bluegrass", "de":"bluegrass"}'],
            ['id' => 9, 'parent_id' => 7, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Кантри-поп", "en":"Country-pop", "de":"Country-pop"}', 'slug' => '{"ru":"kantry-pop", "en":"country-pop", "de":"country-pop"}'],
            ['id' => 10, 'parent_id' => 7, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Альт-кантри", "en":"Alt-country", "de":"Alt-Country"}', 'slug' => '{"ru":"alt-kantry", "en":"alt-country", "de":"alt-country"}'],
            ['id' => 11, 'parent_id' => 7, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Хонки-тонк", "en":"Honky-Tonk", "de":"Honky-Tonk"}', 'slug' => '{"ru":"honky-tonk", "en":"honky-tonk", "de":"honky-tonk"}'],
            ['id' => 12, 'parent_id' => 1, 'lft' => NULL, 'rgt' => NULL, 'depth' => 2, 'name' => '{"ru":"Латиноамериканская музыка", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 13, 'parent_id' => 12, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Бачата", "en":"", "de":""}', 'slug' => '{"ru":"bachata", "en":"", "de":""}'],
            ['id' => 14, 'parent_id' => 12, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Зук", "en":"", "de":""}', 'slug' => '{"ru":"zuk", "en":"", "de":""}'],
            ['id' => 15, 'parent_id' => 12, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Кумбия", "en":"", "de":""}', 'slug' => '{"ru":"kumbiya", "en":"", "de":""}'],
            ['id' => 16, 'parent_id' => 12, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Ламбада", "en":"", "de":""}', 'slug' => '{"ru":"lambada", "en":"", "de":""}'],
            ['id' => 17, 'parent_id' => 12, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Мамбо", "en":"", "de":""}', 'slug' => '{"ru":"mambo", "en":"", "de":""}'],
            ['id' => 18, 'parent_id' => 12, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Меренге", "en":"", "de":""}', 'slug' => '{"ru":"merenge", "en":"", "de":""}'],
            ['id' => 19, 'parent_id' => 12, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Пачанга", "en":"", "de":""}', 'slug' => '{"ru":"pachanga", "en":"", "de":""}'],
            ['id' => 20, 'parent_id' => 12, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Румба", "en":"", "de":""}', 'slug' => '{"ru":"rumba", "en":"", "de":""}'],
            ['id' => 21, 'parent_id' => 12, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Сальса", "en":"", "de":""}', 'slug' => '{"ru":"saljsa", "en":"", "de":""}'],
            ['id' => 22, 'parent_id' => 12, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Самба", "en":"", "de":""}', 'slug' => '{"ru":"samba", "en":"", "de":""}'],
            ['id' => 23, 'parent_id' => 12, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Сон", "en":"", "de":""}', 'slug' => '{"ru":"son", "en":"", "de":""}'],
            ['id' => 24, 'parent_id' => 12, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Танго", "en":"", "de":""}', 'slug' => '{"ru":"tango", "en":"", "de":""}'],
            ['id' => 25, 'parent_id' => 12, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Форро", "en":"", "de":""}', 'slug' => '{"ru":"forro", "en":"", "de":""}'],
            ['id' => 26, 'parent_id' => 12, 'lft' => NULL, 'rgt' => NULL, 'depth' => 3, 'name' => '{"ru":"Ча-ча-ча", "en":"", "de":""}', 'slug' => '{"ru":"cha-cha-cha", "en":"", "de":""}'],
            /*['id' => 27, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 28, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 29, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 30, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 31, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 32, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 33, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 34, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 35, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 36, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 37, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 38, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 39, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 40, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 41, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 42, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 43, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 44, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 45, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 46, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 47, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 48, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 49, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 50, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 51, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 52, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 53, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 54, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 55, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 56, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 57, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 58, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 59, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 60, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 61, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 62, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 63, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 64, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 65, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 66, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 67, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 68, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 69, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 70, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 71, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 72, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 73, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 74, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 75, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 76, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 77, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 78, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 79, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 80, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 81, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 82, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 83, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 84, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 85, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 86, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 87, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 88, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 89, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 90, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 91, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 92, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 93, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 94, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 95, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 96, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 97, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 98, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 99, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 100, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 101, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 102, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 103, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 104, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 105, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 106, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 107, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 108, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 109, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 110, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 111, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 112, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 113, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 114, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 115, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 116, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 117, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 118, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 119, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 120, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 121, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 122, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 123, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 124, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 125, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 126, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 127, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 128, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 129, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 130, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 131, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 132, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 133, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 134, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 135, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 136, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 137, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 138, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 139, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}'],
            ['id' => 140, 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'name' => '{"ru":"", "en":"", "de":""}', 'slug' => '{"ru":"", "en":"", "de":""}']*/
        ];

        foreach($data as $d) {
            $id = $d['id'];
            $parent_id = $d['parent_id'];
            $lft = $d['lft'];
            $rgt = $d['rgt'];
            $depth = $d['depth'];
            $name = $d['name'];
            $slug = $d['slug'];

            DB::table('songs_genres')->updateOrInsert(
                ['id' => $id],
                [
                    'id' => $id,
                    'parent_id' => $parent_id,
                    'lft' => $lft,
                    'rgt' => $rgt,
                    'depth' => $depth,
                    'name' => $name,
                    'slug' => $slug
                ]
            );
        }

        $countDBGenres = DB::table('songs_genres')->count();

        $this->line('=======================================================');
        $this->line('Updated entries: ' . $countDBGenres);
        $this->line('=======================================================');

        $this->info('Added or updated (' . $countDBGenres . ') records in the database!');
    }

}
