<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teachers')->insert([
            [
                'name' => 'Le Nguyen Phuc Nhan',
                'email' => 'teacher1@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
            ],
            [
                'name' => 'Nguyen Thi Minh Chau',
                'email' => 'teacher2@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
            ],
        ]);
    }
}
