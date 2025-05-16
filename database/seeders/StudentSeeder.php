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
    }
}
