<?php

namespace Database\Seeders;

use App\Models\OshoDistributors;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class OshoDistributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path( "/data/distributors.json"));
        $data = json_decode($json);
        foreach ($data as $obj) {
            OshoDistributors::create(array(
                'distributorName' => $obj->distributorName,
                'countyDimension' => $obj->countyDimension,
                'phoneNumber' => $obj->phoneNumber
            ));
        }
    }
}
