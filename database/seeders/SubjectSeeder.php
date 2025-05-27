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
                'name' => 'IT English',
                'description' => 'IT English" is a course that teaches English for IT, focusing on technical terms, communication skills, and technical discussions.',
                'teacher_id' => 4, 
                'class_id' => 1,
                'img' => 'it_english.png',
                'created_at' => now(),
            ],
            [
                'name' => 'TOEIC',
                'description' => 'TOEIC is a course that prepares students for the Test of English for International Communication, focusing on improving listening, reading, speaking, and writing skills for a professional environment.',
                'teacher_id' => 2,  
                'class_id' => 1,
                'img' => 'toeic.png',
                'created_at' => now(),
            ],
            [
                'name' => 'Speaking',
                'description' => 'The Speaking course focuses on improving verbal communication skills in English, emphasizing pronunciation, fluency, and the ability to engage in everyday and professional conversations.',
                'teacher_id' => 3,  
                'class_id' => 1,
                'img' => 'speaking.png',
                'created_at' => now(),
            ],
        ]);
    }
}
