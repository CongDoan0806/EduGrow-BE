<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notifications')->insert([
            [
                'id' => 9,
                'type' => 'goal_created',
                'message' => "Sinh viên Tran Cong Doan đã tạo mục tiêu mới: 'Speaking influence' cho môn ",
                'student_id' => 1,
                'teacher_id' => 4,
                'subject_id' => 1,
                'goal_id' => 10,
                'tag_id' => null,
                'reply_id' => null,
                'is_read' => false,
                'created_at' => '2025-05-26 19:32:45',
                'updated_at' => '2025-05-26 19:32:45',
            ],
            [
                'id' => 10,
                'type' => 'goal_updated',
                'message' => "Sinh viên Tran Cong Doan đã cập nhật mục tiêu: 'Get 9 points' cho môn ",
                'student_id' => 1,
                'teacher_id' => 4,
                'subject_id' => 1,
                'goal_id' => 9,
                'tag_id' => null,
                'reply_id' => null,
                'is_read' => false,
                'created_at' => '2025-05-26 19:34:30',
                'updated_at' => '2025-05-26 19:34:30',
            ],
            [
                'id' => 11,
                'type' => 'goal_updated',
                'message' => "Sinh viên Tran Cong Doan đã cập nhật mục tiêu: 'Complete all assignments on time' cho môn ",
                'student_id' => 1,
                'teacher_id' => 4,
                'subject_id' => 4,
                'goal_id' => 6,
                'tag_id' => null,
                'reply_id' => null,
                'is_read' => false,
                'created_at' => '2025-05-26 19:56:46',
                'updated_at' => '2025-05-26 19:56:46',
            ],
        ]);
    }
}
