<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // ['available', 'borrowed', 'processing'];
        // \App\Models\Status::factory(10)->create();
        \App\Models\Status::create(['name' => 'available']);
        \App\Models\Status::create(['name' => 'borrowed']);
        \App\Models\Status::create(['name' => 'processing']);
    }
}
