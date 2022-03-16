<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('diseases')->insert([
            //tomatoes
            ['name' => 'Damping-off'],
            ['name' => 'Fusarium wilt'],
            ['name' => 'Bacterial wilt'],
            ['name' => 'Bacterial canker'],
            ['name' => 'Bacterial rot'],
            ['name' => 'Bacterial speck'],
            ['name' => 'Common scab'],
            ['name' => 'Fruit rot'],
            ['name' => 'Powdery mildew'],
            ['name' => 'Early blight'],
            ['name' => 'Late blight'],
            ['name' => 'Anthracnose'],
            ['name' => 'Botrytis'],
            ['name' => 'Tomato leaf curl virus'],
            ['name' => 'Tomoto mosaic virus'],
            ['name' => 'Tomato top curl virus'],
            ['name' => 'Tomato spotted wilt virus'],
            ['name' => 'Cutworms'],
            ['name' => 'Aphids'],
            ['name' => 'Whiteflies'],
            ['name' => 'Bollworms'],
            ['name' => 'Thrips'],
            ['name' => 'Mealybugs'],
            ['name' => 'Red spidermites'],
            ['name' => 'Leaf miners'],
            ['name' => 'Tuta Absoluta'],
            //maize
//            ['name' => 'Weeds-Annual and Perennial grasses and broad leaved weeds'],
//            ['name' => 'Water retention'],
//            ['name' => 'Soil structure'],
//            ['name' => 'Nutrient lock-up'],
//            ['name' => 'Leaching'],
//            ['name' => 'Shoot sprouting'],
//            ['name' => 'Plant stress'],
//            ['name' => 'Nutrient uptake'],
//            ['name' => 'Chlorophyll'],
//            ['name' => 'weeds-Annual grasses and broad leaved weeds'],
//            ['name' => '1st Weed control'],
//            ['name' => 'Broad leaved weeds in maize'],
//            ['name' => 'Nutrition'],
//            ['name' => 'Increased root development and nutrient uptake'],
//            ['name' => 'Immunity boost and improved root development'],
//            ['name' => '2nd weed control'],
//            ['name' => 'Stalk borer'],
//            ['name' => 'Leaf hoppers, aphids Bollworm, ear worm'],
//            ['name' => 'Fall army worm'],
//            ['name' => 'Nutrition- Foliar fertilizer'],
//            ['name' => 'Biostimulant'],
//            ['name' => 'Grey leaf spot'],
//            ['name' => 'Sticker, spreader and wetter'],
//            ['name' => 'Sticker, spreader and wetter and mite control'],
//            ['name' => 'Storage pests-Large grain borer (Osama), Weevils, Flour beetles, grain moth'],
//            //potatoes
//            ['name' => 'Nematode'],
//            ['name' => 'White flies'],
//            ['name' => 'Potato tuber moth'],
//            ['name' => 'Leaf miner'],
//            ['name' => 'Downey mildew'],
//            ['name' => 'Early and Late Blights'],
//            ['name' => 'Annual grasses and broad leaved weeds'],
        ]);
    }
}
