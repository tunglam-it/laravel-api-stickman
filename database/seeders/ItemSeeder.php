<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name'=>'Spear',
                'type'=>1,
                'atk'=>50,
                'head_def'=>0,
                'body_def'=>0,
                'hp'=>0,
                'rarity'=>1,
                'stat_increment'=>5,
                'price_increment'=>100,
                'max_level'=>10
            ],
            [
                'name'=>'Spear',
                'type'=>1,
                'atk'=>70,
                'head_def'=>0,
                'body_def'=>0,
                'hp'=>0,
                'rarity'=>2,
                'stat_increment'=>10,
                'price_increment'=>200,
                'max_level'=>15
            ],
            [
                'name'=>'Spear',
                'type'=>1,
                'atk'=>90,
                'head_def'=>0,
                'body_def'=>0,
                'hp'=>0,
                'rarity'=>3,
                'stat_increment'=>15,
                'price_increment'=>300,
                'max_level'=>20
            ],
            [
                'name'=>'Spear',
                'type'=>1,
                'atk'=>110,
                'head_def'=>0,
                'body_def'=>0,
                'hp'=>0,
                'rarity'=>4,
                'stat_increment'=>20,
                'price_increment'=>350,
                'max_level'=>25
            ],
            [
                'name'=>'Shield',
                'type'=>2,
                'atk'=>0,
                'head_def'=>0,
                'body_def'=>100,
                'hp'=>0,
                'rarity'=>1,
                'stat_increment'=>20,
                'price_increment'=>100,
                'max_level'=>10
            ],
            [
                'name'=>'Shield',
                'type'=>2,
                'atk'=>0,
                'head_def'=>0,
                'body_def'=>150,
                'hp'=>0,
                'rarity'=>2,
                'stat_increment'=>30,
                'price_increment'=>200,
                'max_level'=>15
            ],
            [
                'name'=>'Shield',
                'type'=>2,
                'atk'=>0,
                'head_def'=>0,
                'body_def'=>200,
                'hp'=>0,
                'rarity'=>3,
                'stat_increment'=>40,
                'price_increment'=>300,
                'max_level'=>20
            ],
            [
                'name'=>'Shield',
                'type'=>2,
                'atk'=>0,
                'head_def'=>0,
                'body_def'=>250,
                'hp'=>0,
                'rarity'=>4,
                'stat_increment'=>50,
                'price_increment'=>350,
                'max_level'=>25
            ],
            [
                'name'=>'Helmet',
                'type'=>3,
                'atk'=>0,
                'head_def'=>100,
                'body_def'=>0,
                'hp'=>0,
                'rarity'=>1,
                'stat_increment'=>20,
                'price_increment'=>100,
                'max_level'=>10
            ],
            [
                'name'=>'Helmet',
                'type'=>3,
                'atk'=>0,
                'head_def'=>150,
                'body_def'=>0,
                'hp'=>0,
                'rarity'=>2,
                'stat_increment'=>30,
                'price_increment'=>200,
                'max_level'=>15
            ],
            [
                'name'=>'Helmet',
                'type'=>3,
                'atk'=>0,
                'head_def'=>200,
                'body_def'=>0,
                'hp'=>0,
                'rarity'=>3,
                'stat_increment'=>40,
                'price_increment'=>300,
                'max_level'=>20
            ],
            [
                'name'=>'Helmet',
                'type'=>3,
                'atk'=>0,
                'head_def'=>250,
                'body_def'=>0,
                'hp'=>0,
                'rarity'=>4,
                'stat_increment'=>50,
                'price_increment'=>350,
                'max_level'=>25
            ],
            [
                'name'=>'Cloak',
                'type'=>4,
                'atk'=>0,
                'head_def'=>0,
                'body_def'=>0,
                'hp'=>200,
                'rarity'=>1,
                'stat_increment'=>20,
                'price_increment'=>100,
                'max_level'=>10
            ],
            [
                'name'=>'Cloak',
                'type'=>4,
                'atk'=>0,
                'head_def'=>0,
                'body_def'=>0,
                'hp'=>250,
                'rarity'=>2,
                'stat_increment'=>30,
                'price_increment'=>200,
                'max_level'=>15
            ],
            [
                'name'=>'Cloak',
                'type'=>4,
                'atk'=>0,
                'head_def'=>0,
                'body_def'=>0,
                'hp'=>300,
                'rarity'=>3,
                'stat_increment'=>40,
                'price_increment'=>300,
                'max_level'=>20
            ],
            [
                'name'=>'Cloak',
                'type'=>4,
                'atk'=>0,
                'head_def'=>0,
                'body_def'=>0,
                'hp'=>350,
                'rarity'=>4,
                'stat_increment'=>50,
                'price_increment'=>350,
                'max_level'=>25
            ],
        ];

        foreach ($items as $item){
            Item::create($item);
        }
    }
}
