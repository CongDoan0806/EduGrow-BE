<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SemesterGoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('semester_goals')->insert([
            [
                'sg_id' => 1,
                'student_id' => 1,
                'subject_id' => 1,
                'semester' => 'Semester 1',
                'deadline' => '2025-06-30',
                'created_at' => '2025-05-22 21:10:27',
            ],
            [
                'sg_id' => 2,
                'student_id' => 1,
                'subject_id' => 2,
                'semester' => 'Semester 1',
                'deadline' => '2025-12-15',
                'created_at' => '2025-05-22 21:10:27',
            ],
            [
                'sg_id' => 3,
                'student_id' => 1,
                'subject_id' => 2,
                'semester' => 'Semester 1',
                'deadline' => '2025-12-15',
                'created_at' => '2025-05-22 21:10:27',
            ],
            [
                'sg_id' => 4,
                'student_id' => 1,
                'subject_id' => 4,
                'semester' => 'Học kỳ 1 2024-2025',
                'deadline' => '2025-05-23',
                'created_at' => '2025-05-23 10:16:16',
            ],
            [
                'sg_id' => 5,
                'student_id' => 1,
                'subject_id' => 3,
                'semester' => 'Học kỳ 1 2024-2025',
                'deadline' => '2025-05-23',
                'created_at' => '2025-05-23 13:50:44',
            ],
        ]);
    }
}
