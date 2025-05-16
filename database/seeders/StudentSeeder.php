<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run()
    {
       DB::table('students')->insert([
        [
            'name' => 'Tran Cong Doan',
            'email' => 'student1@example.com',
            'password' => Hash::make('password123'),
            'avatar' => 'default1.jpg',
            'created_at' => now(),
        ],
        [
            'name' => 'To Nga',
            'email' => 'student2@example.com',
            'password' => Hash::make('password123'),
            'avatar' => 'default2.jpg',
            'created_at' => now(),
        ],
    ]);

        DB::table('subjects')->insert([
        [
            'created_at' => now(),
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'img' => 'web-dev.jpg',
            'name' => 'TOEIC',
            'teacher_id' => 1, // Thêm trường teacher_id nếu có
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
            'description' => 'Build mobile apps using Android Studio.',
            'img' => 'mobile-app.jpg',
            'name' => 'IT English',
            'teacher_id' => 1,
        ],
    ]);

        
    }
}
