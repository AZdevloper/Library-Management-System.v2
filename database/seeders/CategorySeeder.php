<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $statuses = ['Science Fiction', 'Mystery', 'Romance'];

        // \App\Models\Category::factory(10)->create();
        \App\Models\Category::create(['name' => 'Science Fiction']);
        \App\Models\Category::create(['name' => 'Mystery']);
        \App\Models\Category::create(['name' => 'Romance']);
    }
}
