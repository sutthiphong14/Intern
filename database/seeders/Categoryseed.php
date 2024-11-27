<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Categoryseed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

            
        Category::insert([
            ['name' => 'FeedNews'],
            ['name' => 'ผลการดำเนินงานด้านการตลาด สายงาน ภน.'],
            ['name' => 'คุณภาพบริการ'],
            ['name' => 'ผลการดำเนินงาน สายงาน ภน.'],
        ]);
        
      
    }
}
