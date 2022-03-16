<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('counties')->insert([
            ['name' => 'Bungoma'], ['name' => 'Nyeri'], ['name' => 'Kilifi'],
            ['name' => 'Narok'], ['name' => 'Trans Nzoia'], ['name' => 'Kakamega'],
            ['name' => 'Baringo'], ['name' => 'Nairobi'], ['name' => 'Kajiado'],
            ['name' => 'Meru'], ['name' => 'Tharaka Nithi'],
            ['name' => 'Kisumu'], ['name' => 'Homa Bay'], ['name' => 'Nakuru'],
            ['name' => 'Kiambu'], ['name' => 'Tana River'], ['name' => 'Kitui'],
            ['name' => 'Kericho'], ['name' => 'Elgeyo Marakwet'], ['name' => 'Laikipia'],
            ['name' => 'Kisii'], ['name' => 'Nyandarua'], ['name' => 'Migori'],
            ['name' => 'Kirinyaga'], ['name' => 'Vihiga'], ['name' => 'Embu'],

            ['name' => 'Makueni'], ['name' => 'Bomet'], ['name' => 'Mombasa'], ['name' => 'Nandi'],
            ['name' => 'West Pokot'], ['name' => 'Busia'], ['name' => 'Uasin Gishu'],
            ['name' => 'Nyamira'], ['name' => 'Muranga'], ['name' => 'Machakos'],

            ['name' => 'Taita Taveta'], ['name' => 'Siaya'], ['name' => 'Isiolo'],
            ['name' => 'Garissa'], ['name' => 'Kwale']
        ]);
    }
}
