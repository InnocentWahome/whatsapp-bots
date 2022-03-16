<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('crops')->insert([
            ['name' => 'Tomatoes','etag' => '799680000'],
//            ['name' => 'Potatoes','etag' => '799680001'],
//            ['name' => 'Maize','etag' => '799680002'],
            ['name' => 'Other','etag' => '799690000']
        ]);
    }
}
