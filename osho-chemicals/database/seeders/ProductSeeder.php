<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            //tomatoes
            ['crop_id' => '1', 'crop_number' => '1', 'disease' => 'Damping-off', 'product' => 'Matco (50g/20L)'],
            ['crop_id' => '1', 'crop_number' => '2', 'disease' => 'Fusarium wilt', 'product' => 'PEARL EXTRA 50% SC (20mls/20L)'],
            ['crop_id' => '1', 'crop_number' => '3', 'disease' => 'Bacterial wilt', 'product' => 'Enrich BM (20g/20L)'],
            ['crop_id' => '1', 'crop_number' => '4', 'disease' => 'Bacterial canker', 'product' => 'Enrich BM (20g/20L)'],
            ['crop_id' => '1', 'crop_number' => '5', 'disease' => 'Bacterial rot', 'product' => 'Enrich BM (20g/20L)'],
            ['crop_id' => '1', 'crop_number' => '6', 'disease' => 'Bacterial speck', 'product' => 'Enrich BM (20g/20L)'],
            ['crop_id' => '1', 'crop_number' => '7', 'disease' => 'Common scab', 'product' => 'Topcop 50WP (50g/20L)'],
            ['crop_id' => '1', 'crop_number' => '8', 'disease' => 'Fruit rot', 'product' => 'Wetsulf Jet (50g/20L)'],
            ['crop_id' => '1', 'crop_number' => '9', 'disease' => 'Powdery mildew', 'product' => 'Wetsulf jet (50g/20L)'],
            ['crop_id' => '1', 'crop_number' => '10', 'disease' => 'Early blight', 'product' => 'Oshothane 80WP (50g/20L)'],
            ['crop_id' => '1', 'crop_number' => '11', 'disease' => 'Late blight', 'product' => ' MATCO 72WP(50gm/20ltr)/MISTRESS 72%WP(40gm/20L) '],
            ['crop_id' => '1', 'crop_number' => '12', 'disease' => 'Anthracnose', 'product' => 'Matco 72 WP (50g/20L)'],
            ['crop_id' => '1', 'crop_number' => '13', 'disease' => 'Botrytis', 'product' => 'PEARL EXTRA 50% SC (20mls/20L), Oshothane Plus 75WDG (40g/20L)'],
            ['crop_id' => '1', 'crop_number' => '14', 'disease' => 'Tomato leaf curl virus', 'product' => 'Control Whiteflies (Final flight 8g/20L)'],
            ['crop_id' => '1', 'crop_number' => '15', 'disease' => 'Tomoto mosaic virus', 'product' => 'Control Aphids (Alpha Degree 10mls/20L)'],
            ['crop_id' => '1', 'crop_number' => '16', 'disease' => 'Tomato top curl virus', 'product' => 'Control Leaf hoppers (Dynamo 3g/20L)'],
            ['crop_id' => '1', 'crop_number' => '17', 'disease' => 'Tomato spotted wilt virus', 'product' => 'Control Thrips ( Umeme top 10mls/20L)'],
            ['crop_id' => '1', 'crop_number' => '18', 'disease' => 'Cutworms', 'product' => 'Umeme Top (8mls/20L)'],
            ['crop_id' => '1', 'crop_number' => '19', 'disease' => 'Aphids', 'product' => 'Alpha degree (10mls/20L)'],
            ['crop_id' => '1', 'crop_number' => '20', 'disease' => 'Whiteflies', 'product' => 'Alpha degree (10mls/20L)'],
            ['crop_id' => '1', 'crop_number' => '21', 'disease' => 'Bollworms', 'product' => 'Umeme top (10mls/20L)'],
            ['crop_id' => '1', 'crop_number' => '22', 'disease' => 'Thrips', 'product' => 'Final flight (8g/20L)'],
            ['crop_id' => '1', 'crop_number' => '23', 'disease' => 'Mealybugs', 'product' => 'Protest (10mls/20L)'],
            ['crop_id' => '1', 'crop_number' => '24', 'disease' => 'Red spidermites', 'product' => 'Climb 18EC (10mls/20L), Nimbecidine (50mls/20L)'],
            ['crop_id' => '1', 'crop_number' => '25', 'disease' => 'Leaf miners', 'product' => 'Climb 18 EC (10mls/20L), Nimbecidine (50mls/20L)'],
            ['crop_id' => '1', 'crop_number' => '26', 'disease' => 'Tuta Absoluta', 'product' => 'Fireworks (10mls/20L), Nimbecidine (50mls/20L)'],

//            //potatoes
//            ['crop_id' => '2', 'crop_number' => '1', 'disease' => 'Potato tuber moth', 'product' => 'FIREWORKS (10mls/20L)'],
//            ['crop_id' => '2', 'crop_number' => '2', 'disease' => 'Leaf miner', 'product' => 'FIREWORKS (10mls/20L),Climb 18 EC (10ml/20L)'],
//            ['crop_id' => '2', 'crop_number' => '3', 'disease' => 'Bacterial wilt', 'product' => 'ENRICH BM (60gm/20ltr) + TOPCOP 50WP (50gm/20ltr)'],
//            ['crop_id' => '2', 'crop_number' => '4', 'disease' => 'Fusarium wilt', 'product' => 'PEARL EXTRA 50% SC (20ml/20ltr) Drench'],
//            ['crop_id' => '2', 'crop_number' => '5', 'disease' => 'Downey mildew', 'product' => 'MISTRESS 72% WP(40gm/20ltr)/MATCO 72WP(50gm/20ltr)'],
//            ['crop_id' => '2', 'crop_number' => '6', 'disease' => 'Early and Late Blights', 'product' => 'OSHOTHANE PLUS  75 WDG (50gm/20ltr)/MATCO 72WP (50gm/20ltr)/MISTRESS 72%WP (40gm/20L) /TOPCOP 50WP (50gm/20ltr)'],
//            ['crop_id' => '2', 'crop_number' => '7', 'disease' => 'Powdery mildew', 'product' => 'TOKEN 325 SC (15ml/20ltr)'],
//            ['crop_id' => '2', 'crop_number' => '8', 'disease' => 'Annual grasses and broad leaved weeds', 'product' => 'Motoplus 25g/20L'],
//            ['crop_id' => '2', 'crop_number' => '9', 'disease' => 'Aphids', 'product' => 'DYNAMO 70 WG (3gm/20ltr), Protest 200 SL (10ml/20L), Winner 100EC (2.5 ml/20L)'],
//            ['crop_id' => '2', 'crop_number' => '10', 'disease' => 'White flies ', 'product' => 'DYNAMO 70 WG (3gm/20ltr), Protest 200 SL (10ml/20L), Winner 100EC (2.5 ml/20L)'],
//            ['crop_id' => '2', 'crop_number' => '11', 'disease' => 'Nematode', 'product' => 'NIMBECIDINE (100ml/20ltr)/ BIO NEMATON (100ml/20ltr)'],
//            ['crop_id' => '2', 'crop_number' => '12', 'disease' => 'Cutworms', 'product' => 'Umeme Top (8mls/20ltr)'],
//
//
//
//
//
//
//
//            //maize
//            ['crop_id' => '3', 'crop_number' => '1', 'disease' => 'Weeds-Annual and Perennial grasses and broad leaved weeds', 'product' => 'KICK OUT 480 SL (200mls/20L) Applied 1 week pre-planting'],
//            ['crop_id' => '3', 'crop_number' => '2', 'disease' => 'Stalk borer', 'product' => 'TREMOR O.05 GR (3KG/Ha),WINNER 100 EC (2.5mls/20L)'],
//            ['crop_id' => '3', 'crop_number' => '3', 'disease' => 'Broad leaved weeds in maize', 'product' => 'D-AMINE 72SL (150mls/20L)'],
//            ['crop_id' => '3', 'crop_number' => '4', 'disease' => 'Nutrition', 'product' => 'EASYGRO STARTER (40g/20L)'],
//            ['crop_id' => '3', 'crop_number' => '5', 'disease' => 'Increased root development and nutrient uptake', 'product' => 'SYMBION VAM PLUS (100gms/20L)'],
//            ['crop_id' => '3', 'crop_number' => '6', 'disease' => 'Nutrient lock-up, Leaching, Water retention, Soil structure.', 'product' => 'BLACK EARTH 85WSG (2kg/50kg Fertilizer)'],
//            ['crop_id' => '3', 'crop_number' => '7', 'disease' => 'Shoot sprouting, Chlorophyll, Nutrient uptake, Plant stress.', 'product' => 'OSHOZYME GR ( 10MLS/20l)'],
//            ['crop_id' => '3', 'crop_number' => '8', 'disease' => 'weeds-Annual grasses and broad leaved weeds', 'product' => 'KOLOPA 300 OD (75mls/20L) Apply once Post-emergence to weeds and the maize (3–5 leaf stage) 21 day after planting maize'],
//            ['crop_id' => '3', 'crop_number' => '9', 'disease' => 'Immunity boost and improved root development', 'product' => 'POTPHOS (20mls/20L)'],
//            ['crop_id' => '3', 'crop_number' => '10', 'disease' => 'Cutworms', 'product' => 'UMEME TOP 5 EC (10mls/20L)'],
//            ['crop_id' => '3', 'crop_number' => '11', 'disease' => 'Leaf hoppers, Aphids, Bollworm, ear worm', 'product' => 'SHOTGUN 20 SP, MAGESTIK 700WDG  (1g/20L), Manique 20% SL (5ml/20L)'],
//            ['crop_id' => '3', 'crop_number' => '12', 'disease' => 'Fall army worm', 'product' => 'RELAY 150SC (2mls/20L),LOTUS®75%SP (10g/20L),XPAND MAX®92SG (10g/20L),PASSWORD 57WDG (4g/20L)'],
//            ['crop_id' => '3', 'crop_number' => '13', 'disease' => 'Nutrition- Foliar fertilizer', 'product' => 'AGROFEED (50mls/20lL)'],
//            ['crop_id' => '3', 'crop_number' => '14', 'disease' => 'Biostimulant', 'product' => 'OSHOZYME LIQUID (10MLS/20l)'],
//            ['crop_id' => '3', 'crop_number' => '15', 'disease' => 'Grey leaf spot', 'product' => 'TOKEN®325SC'],
//            ['crop_id' => '3', 'crop_number' => '16', 'disease' => 'Sticker, spreader and wetter', 'product' => 'AQUAWET (10mls/20L)'],
//            ['crop_id' => '3', 'crop_number' => '17', 'disease' => 'Sticker, spreader and wetter and mite control', 'product' => 'MAGNUM GOLD'],
//            ['crop_id' => '3', 'crop_number' => '18', 'disease' => 'Storage pests-Large grain borer (Osama), Weevils, Flour beetles, grain moth', 'product' => 'SKANA SUPER'],
//
//            ['crop_id' => '3', 'crop_number' => '19', 'disease' => '1st Weed control', 'product' => 'HERBIKILL 200SL (100mls/20L)'],
//            ['crop_id' => '3', 'crop_number' => '20', 'disease' => '2nd weed control', 'product' => 'HERBIKILL 20 SL (100mls/20L)'],
//            ['crop_id' => '3', 'crop_number' => '21', 'disease' => '1st Weed control', 'product' => 'GLUSAR 18% SL (160mls/20L)'],













        ]);
    }
}
