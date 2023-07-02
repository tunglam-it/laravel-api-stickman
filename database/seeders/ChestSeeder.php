<?php

namespace Database\Seeders;

use App\Models\Chest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name'=>'Common Chest',
                'type'=>0,
                'price'=>60
            ]
            ,[
                'name'=>'Rare Chest',
                'type'=>1,
                'price'=>120
            ]
            ,[
                'name'=>'Epic Chest',
                'type'=>2,
                'price'=>200
            ]
            ,
        ];

        foreach ($data as $datum){
            Chest::create($datum);
        }
    }
}
