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
            // class_id = 1 (3 học sinh)
            [
                'student_id' => 1,
                'name' => 'Tran Cong Doan',
                'email' => 'student1@example.com',
                'password' => Hash::make('password123'),
                'class_id' => 1,
                'phone' => '0123456789',
                'avatar' => 'default1.jpg',
                'class_name' => 'PNV26A',
            ],
            [
                'student_id' => 2,
                'name' => 'To Nga',
                'email' => 'student2@example.com',
                'password' => Hash::make('password123'),
                'class_id' => 1,
                'phone' => '0123456789',
                'avatar' => 'default1.jpg',
                'class_name' => 'PNV26A',
            ],
            [
                'student_id' => 3,
                'name' => 'Nguyen Van Đat',
                'email' => 'student3@example.com',
                'password' => Hash::make('password123'),
                'class_id' => 1,
                'phone' => '0123456789',
                'avatar' => 'default1.jpg',
                'class_name' => 'PNV26A',
            ],

            // class_id = 2 (4 học sinh)
            [
                'student_id' => 4,
                'name' => 'Le Thi Bich Thuy',
                'email' => 'student4@example.com',
                'password' => Hash::make('password123'),
                'class_id' => 2,
                'phone' => '0123456789',
                'avatar' => 'default1.jpg',
                'class_name' => 'PNV26A',
            ],
            [
                'student_id' => 5,
                'name' => 'Pham Van Nam',
                'email' => 'student5@example.com',
                'password' => Hash::make('password123'),
                'class_id' => 2,
                'phone' => '0123456789',
                'avatar' => 'default1.jpg',
                'class_name' => 'PNV26A',
            ],
            [
                'student_id' => 6,
                'name' => 'Hoang Thi Duyen',
                'email' => 'student6@example.com',
                'password' => Hash::make('password123'),
                'class_id' => 2,
                'phone' => '0123456789',
                'avatar' => 'default1.jpg',
                'class_name' => 'PNV26A',
            ],
            [
                'student_id' => 7,
                'name' => 'Nguyen Van Thien',
                'email' => 'student7@example.com',
                'password' => Hash::make('password123'),
                'class_id' => 2,
                'phone' => '0123456789',
                'avatar' => 'default1.jpg',
                'class_name' => 'PNV26A',
            ],

            // class_id = 3 (5 học sinh)
            [
                'student_id' => 8,
                'name' => 'Tran Thi Bich Thuy',
                'email' => 'student8@example.com',
                'password' => Hash::make('password123'),
                'class_id' => 3,
                'phone' => '0123456789',
                'avatar' => 'default1.jpg',
                'class_name' => 'PNV26A',
            ],
            [
                'student_id' => 9,
                'name' => 'Do Van Giang',
                'email' => 'student9@example.com',
                'password' => Hash::make('password123'),
                'class_id' => 3,
                'phone' => '0123456789',
                'avatar' => 'default1.jpg',
                'class_name' => 'PNV26A',
            ],
            [
                'student_id' => 10,
                'name' => 'Le Thi Hong Duyen',
                'email' => 'student10@example.com',
                'password' => Hash::make('password123'),
                'class_id' => 3,
                'phone' => '0123456789',
                'avatar' => 'default1.jpg',
                'class_name' => 'PNV26A',
            ],
            [
                'student_id' => 11,
                'name' => 'Pham Van Linh',
                'email' => 'student11@example.com',
                'password' => Hash::make('password123'),
                'class_id' => 3,
                'phone' => '0123456789',
                'avatar' => 'default1.jpg',
                'class_name' => 'PNV26A',
            ],
            [
                'student_id' => 12,
                'name' => 'Nguyen Thi Kim Ngan',
                'email' => 'student12@example.com',
                'password' => Hash::make('password123'),
                'class_id' => 3,
                'phone' => '0123456789',
                'avatar' => 'default1.jpg',
                'class_name' => 'PNV26A',
            ],
        ]);
    }
}
