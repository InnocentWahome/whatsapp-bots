<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->insert(
            ['name' => 'Physical Location: Osho Complex,
Sasio Rd, off Lunga lunga,
Industrial Area Nairobi Kenya
Phone numbers: (+254) 0711 045000
/ 0732 167000 / 020 3912000
Email address:
oshochem@oshochem.com
SMS Shortcode: 20560
Website url: http://oshochem.com/
Facebook url:
https://www.facebook.com/OshoChem
Twitter url:
https://twitter.com/Oshochem']
        );
    }
}
