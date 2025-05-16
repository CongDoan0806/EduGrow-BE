<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        DB::table('subjects')->insert([
        [
            'created_at' => now(),
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'img' => 'web-dev.jpg',
            'name' => 'TOEIC',
            'teacher_id' => 1,
        ],
        [
            'created_at' => now(),
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'img' => 'database.jpg',
            'name' => 'Speaking',
            'teacher_id' => 2,
        ],
        [
            'created_at' => now(),
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'img' => 'mobile-app.jpg',
            'name' => 'IT English',
            'teacher_id' => 1,
        ],
    ]);      
    }
}
