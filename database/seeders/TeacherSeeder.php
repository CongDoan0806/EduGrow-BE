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
                'title' => 'Giảng viên Toeic',
                'email' => 'teacher1@example.com',
                'password' => Hash::make('password123'),
                'image' => 'https://randomuser.me/api/portraits/women/1.jpg',
                'facebook' => 'https://facebook.com/lenguyenphucnhan',
                'linkedin' => 'https://linkedin.com/in/lenguyenphucnhan',
                'twitter' => 'https://twitter.com/lenguyenphucnhan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Trang Nguyen',
                'title' => 'Giảng viên TOEIC',
                'email' => 'trangnguyen@gmail.com',
                'password' => Hash::make('password101'),
                'image' => 'https://randomuser.me/api/portraits/women/1.jpg',
                'facebook' => 'https://facebook.com/trangnguyen',
                'linkedin' => 'https://linkedin.com/in/trangnguyen',
                'twitter' => 'https://twitter.com/trangnguyen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nhan Le',
                'title' => 'Giảng viên Speaking',
                'email' => 'nhanle@gmail.com',
                'password' => Hash::make('password102'),
                'image' => 'https://randomuser.me/api/portraits/men/1.jpg',
                'facebook' => 'https://facebook.com/nhanle',
                'linkedin' => 'https://linkedin.com/in/nhanle',
                'twitter' => 'https://twitter.com/nhanle',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Uyen Tran',
                'title' => 'Giảng viên IELTS',
                'email' => 'uyentran@gmail.com',
                'password' => Hash::make('password103'),
                'image' => 'https://randomuser.me/api/portraits/women/2.jpg',
                'facebook' => 'https://facebook.com/uyentran',
                'linkedin' => 'https://linkedin.com/in/uyentran',
                'twitter' => 'https://twitter.com/uyentran',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}