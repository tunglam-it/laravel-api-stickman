<?php

namespace Database\Seeders;

use App\Models\ItemUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'user_id'=>2,
                'item_id'=>1,
                'current_level'=>1,
                'status'=>2,
                'atk'=>50,
                'body_def'=>0,
                'head_def'=>0,
                'hp'=>0
            ]
            ,
            [
                'user_id'=>2,
                'item_id'=>2,
                'current_level'=>2,
                'status'=>2,
                'atk'=>80,
                'body_def'=>0,
                'head_def'=>0,
                'hp'=>0
            ]
            ,
            [
                'user_id'=>2,
                'item_id'=>4,
                'current_level'=>4,
                'status'=>2,
                'atk'=>190,
                'body_def'=>0,
                'head_def'=>0,
                'hp'=>0
            ]
            ,
            [
                'user_id'=>2,
                'item_id'=>5,
                'current_level'=>1,
                'status'=>2,
                'atk'=>0,
                'body_def'=>100,
                'head_def'=>0,
                'hp'=>0
            ]
            ,
            [
                'user_id'=>2,
                'item_id'=>6,
                'current_level'=>2,
                'status'=>2,
                'atk'=>0,
                'body_def'=>130,
                'head_def'=>0,
                'hp'=>0
            ]
            ,
            [
                'user_id'=>2,
                'item_id'=>10,
                'current_level'=>4,
                'status'=>2,
                'atk'=>0,
                'body_def'=>0,
                'head_def'=>240,
                'hp'=>0
            ]
            ,
            [
                'user_id'=>2,
                'item_id'=>11,
                'current_level'=>1,
                'status'=>2,
                'atk'=>0,
                'body_def'=>0,
                'head_def'=>200,
                'hp'=>0
            ]
            ,
            [
                'user_id'=>2,
                'item_id'=>13,
                'current_level'=>2,
                'status'=>2,
                'atk'=>0,
                'body_def'=>0,
                'head_def'=>0,
                'hp'=>220
            ]
            ,
            [
                'user_id'=>2,
                'item_id'=>14,
                'current_level'=>4,
                'status'=>2,
                'atk'=>0,
                'body_def'=>0,
                'head_def'=>0,
                'hp'=>290
            ]
            ,

        ];

        foreach ($items as $item) {
            ItemUser::create($item);
        }
    }
}
