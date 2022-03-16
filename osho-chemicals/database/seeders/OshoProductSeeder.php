<?php

namespace Database\Seeders;

use App\Models\OshoProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class OshoProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path("/data/data.json"));
        $data = json_decode($json);
        foreach ($data as $obj) {
            OshoProduct::create(array(
                'etag' => $obj->etag,
                'tcc_crop' => $obj->tcc_crop,
                'tcc_product' => $obj->tcc_product,
                'tcc_targetpest' => $obj->tcc_targetpest,
                'title' => $obj->title,
                'knowledgearticleid' => $obj->knowledgearticleid
            ));
        }
    }
}
