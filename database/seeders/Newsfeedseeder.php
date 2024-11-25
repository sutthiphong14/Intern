<?php

namespace Database\Seeders;

use App\Models\Newsfeed;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Newsfeedseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Newsfeed::factory()->count(10)->create();
    }
}
