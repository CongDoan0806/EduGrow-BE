<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LearningJournalSeeder extends Seeder
{
    public function run()
    {
        // Thêm dữ liệu vào bảng learning_journal
        DB::table('learning_journal')->insert([
            [
                'student_subject_id' => 1, 
                'semester' => '3',
                'week_number' => 1, 
                'created_at' => now(),
                'start_date' => '2025-04-01',
                'end_date' => '2025-04-07',
            ],
            [
                'student_subject_id' => 2,  
                'semester' => '3',
                'week_number' => 1,  
                'created_at' => now(),
                'start_date' => '2025-04-01',
                'end_date' => '2025-04-07',
            ],
            [
                'student_subject_id' => 3, 
                'semester' => '3',
                'week_number' => 1,  
                'created_at' => now(),
                'start_date' => '2025-04-01',
                'end_date' => '2025-04-07',
            ],
            [
                'student_subject_id' => 4, 
                'semester' => '3',
                'week_number' => 1,  
                'created_at' => now(),
                'start_date' => '2025-04-01',
                'end_date' => '2025-04-07',
            ],
            [
                'student_subject_id' => 5, 
                'semester' => '3',
                'week_number' => 1,  
                'created_at' => now(),
                'start_date' => '2025-04-01',
                'end_date' => '2025-04-07',
            ],
            [
                'student_subject_id' => 1,  
                'semester' => '3',
                'week_number' => 2,  
                'created_at' => now(),
                'start_date' => '2025-04-08',
                'end_date' => '2025-04-14',
            ],
            [
                'student_subject_id' => 2, 
                'semester' => '3',
                'week_number' => 2, 
                'created_at' => now(),
                'start_date' => '2025-04-08',
                'end_date' => '2025-04-14',
            ],
            [
                'student_subject_id' => 3,  
                'semester' => '3',
                'week_number' => 2,  
                'created_at' => now(),
                'start_date' => '2025-04-08',
                'end_date' => '2025-04-14',
            ],
            [
                'student_subject_id' => 4,  
                'semester' => '3',
                'week_number' => 2, 
                'created_at' => now(),
                'start_date' => '2025-04-08',
                'end_date' => '2025-04-14',
            ],
            [
                'student_subject_id' => 5,  
                'semester' => '3',
                'week_number' => 2, 
                'created_at' => now(),
                'start_date' => '2025-04-08',
                'end_date' => '2025-04-14',
            ],
        ]);
    }
}
