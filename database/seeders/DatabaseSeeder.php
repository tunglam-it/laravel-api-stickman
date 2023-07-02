<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

         \App\Models\User::create([
             'username' => 'admin',
             'password' => Hash::make('123456789')
         ]);
         $this->call([
             ItemSeeder::class,
             ItemUserSeeder::class
         ]);
    }
}
