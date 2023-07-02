<?php

namespace Database\Seeders;

use App\Models\ChestItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChestItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'chest_id' =>0,
                'item_id' =>1,
                'ratio' =>84
            ], [
                'chest_id' =>0,
                'item_id' =>2,
                'ratio' =>95
            ], [
                'chest_id' =>0,
                'item_id' =>3,
                'ratio' =>100
            ], [
                'chest_id' =>0,
                'item_id' =>5,
                'ratio' =>84
            ], [
                'chest_id' =>0,
                'item_id' =>6,
                'ratio' =>95
            ], [
                'chest_id' =>0,
                'item_id' =>7,
                'ratio' =>100
            ], [
                'chest_id' =>0,
                'item_id' =>9,
                'ratio' =>84
            ], [
                'chest_id' =>0,
                'item_id' =>10,
                'ratio' =>95
            ], [

                'chest_id' =>0,
                'item_id' =>11,
                'ratio' =>100
            ], [
                'chest_id' =>0,
                'item_id' =>13,
                'ratio' =>84
            ], [
                'chest_id' =>0,
                'item_id' =>14,
                'ratio' =>95
            ], [
                'chest_id' =>0,
                'item_id' =>15,
                'ratio' =>100
            ],
            [
                'chest_id' =>1,
                'item_id' =>1,
                'ratio' =>59
            ], [
                'chest_id' =>1,
                'item_id' =>2,
                'ratio' =>79
            ], [
                'chest_id' =>1,
                'item_id' =>3,
                'ratio' =>94
            ], [
                'chest_id' =>1,
                'item_id' =>4,
                'ratio' =>100
            ], [
                'chest_id' =>1,
                'item_id' =>5,
                'ratio' =>59
            ], [
                'chest_id' =>1,
                'item_id' =>6,
                'ratio' =>79
            ], [
                'chest_id' =>1,
                'item_id' =>7,
                'ratio' =>94
            ], [
                'chest_id' =>1,
                'item_id' =>8,
                'ratio' =>100
            ], [
                'chest_id' =>1,
                'item_id' =>9,
                'ratio' =>59
            ], [
                'chest_id' =>1,
                'item_id' =>10,
                'ratio' =>79
            ], [
                'chest_id' =>1,
                'item_id' =>11,
                'ratio' =>94
            ], [
                'chest_id' =>1,
                'item_id' =>12,
                'ratio' =>100
            ], [
                'chest_id' =>1,
                'item_id' =>13,
                'ratio' =>59
            ], [
                'chest_id' =>1,
                'item_id' =>14,
                'ratio' =>79
            ], [
                'chest_id' =>1,
                'item_id' =>15,
                'ratio' =>94
            ], [
                'chest_id' =>1,
                'item_id' =>16,
                'ratio' =>100
            ],
            [
                'chest_id' =>2,
                'item_id' =>1,
                'ratio' =>49
            ], [
                'chest_id' =>2,
                'item_id' =>2,
                'ratio' =>69
            ], [
                'chest_id' =>2,
                'item_id' =>3,
                'ratio' =>86
            ], [
                'chest_id' =>2,
                'item_id' =>4,
                'ratio' =>100
            ], [
                'chest_id' =>2,
                'item_id' =>5,
                'ratio' =>49
            ], [
                'chest_id' =>2,
                'item_id' =>6,
                'ratio' =>69
            ], [
                'chest_id' =>2,
                'item_id' =>7,
                'ratio' =>86
            ], [
                'chest_id' =>2,
                'item_id' =>8,
                'ratio' =>100
            ], [
                'chest_id' =>2,
                'item_id' =>9,
                'ratio' =>49
            ], [
                'chest_id' =>2,
                'item_id' =>10,
                'ratio' =>69
            ], [
                'chest_id' =>2,
                'item_id' =>11,
                'ratio' =>86
            ], [
                'chest_id' =>2,
                'item_id' =>12,
                'ratio' =>100
            ], [
                'chest_id' =>2,
                'item_id' =>13,
                'ratio' =>49
            ], [
                'chest_id' =>2,
                'item_id' =>14,
                'ratio' =>69
            ], [
                'chest_id' =>2,
                'item_id' =>15,
                'ratio' =>86
            ], [
                'chest_id' =>2,
                'item_id' =>16,
                'ratio' =>100
            ],
        ];
        foreach ($data as $datum){
            ChestItem::create($datum);
        }
    }
}
