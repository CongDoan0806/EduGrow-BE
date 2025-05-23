<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassGroupSeeder extends Seeder
{
     public function run()
    {
        DB::table('class_groups')->insert([
            [
                'class_id' => 1,
                'class_name' => 'ITEnglish_PNV26',
                'created_at' => now(),
            ],
            [
                'class_id' => 2,
                'class_name' => 'TOEIC_PNV26',
                'created_at' => now(),
            ],
            [
                'class_id' => 3,
                'class_name' => 'Communicative_PNV26',
                'created_at' => now(),
            ]
        ]);
    }
}
