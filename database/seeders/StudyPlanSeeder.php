<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudyPlanSeeder extends Seeder
{
    public function run(): void
    {
        $studentIds = DB::table('students')->pluck('student_id')->toArray();

        if (empty($studentIds)) {
            return;
        }

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $yesterday = Carbon::yesterday();

        $studyPlans = [];

        foreach ($studentIds as $studentId) {
            $studyPlans[] = [
                'student_id' => $studentId,
                'title' => 'Learn TOEIC',
                'day_of_week' => $today->format('l'),
                'date' => $today->format('Y-m-d'),
                'start_time' => '08:00:00',
                'end_time' => '09:30:00',
                'color' => '#cfe9ff', // xanh nhạt
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $studyPlans[] = [
                'student_id' => $studentId,
                'title' => 'Practice Speaking',
                'day_of_week' => $today->format('l'),
                'date' => $today->format('Y-m-d'),
                'start_time' => '10:00:00',
                'end_time' => '11:30:00',
                'color' => '#ffcccc', // hồng nhạt
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $studyPlans[] = [
                'student_id' => $studentId,
                'title' => 'Meeting with Mr. Hai',
                'day_of_week' => $today->format('l'),
                'date' => $today->format('Y-m-d'),
                'start_time' => '14:00:00',
                'end_time' => '15:30:00',
                'color' => '#ccffcc', // xanh lá nhạt
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $studyPlans[] = [
                'student_id' => $studentId,
                'title' => 'Interview with mgm',
                'day_of_week' => $tomorrow->format('l'),
                'date' => $tomorrow->format('Y-m-d'),
                'start_time' => '08:00:00',
                'end_time' => '09:30:00',
                'color' => '#ffffcc', // vàng nhạt
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $studyPlans[] = [
                'student_id' => $studentId,
                'title' => 'Doing Homework IT English',
                'day_of_week' => $tomorrow->format('l'),
                'date' => $tomorrow->format('Y-m-d'),
                'start_time' => '10:00:00',
                'end_time' => '11:30:00',
                'color' => '#ffd699', // cam nhạt
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $studyPlans[] = [
                'student_id' => $studentId,
                'title' => 'Practice Presentation',
                'day_of_week' => $yesterday->format('l'),
                'date' => $yesterday->format('Y-m-d'),
                'start_time' => '08:00:00',
                'end_time' => '09:30:00',
                'color' => '#d9ccff', // tím nhạt
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $studyPlans[] = [
                'student_id' => $studentId,
                'title' => 'Learn IT English',
                'day_of_week' => $yesterday->format('l'),
                'date' => $yesterday->format('Y-m-d'),
                'start_time' => '10:00:00',
                'end_time' => '11:30:00',
                'color' => '#cfe9ff', // xanh nhạt lặp lại
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $studyPlans[] = [
                'student_id' => $studentId,
                'title' => 'Practice Speaking',
                'day_of_week' => 'Friday',
                'date' => Carbon::parse('2025-05-13')->format('Y-m-d'),
                'start_time' => '14:00:00',
                'end_time' => '16:00:00',
                'color' => '#ffcccc', // hồng nhạt
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('study_plans')->insert($studyPlans);
    }
}
