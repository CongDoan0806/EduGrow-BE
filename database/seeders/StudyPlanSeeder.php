<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudyPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy danh sách student_id từ bảng students
        $studentIds = DB::table('students')->pluck('student_id')->toArray();
        
        if (empty($studentIds)) {
            return;
        }
        
        // Tạo dữ liệu mẫu cho study_plans
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $yesterday = Carbon::yesterday();
        
        $studyPlans = [];
        
        // Tạo dữ liệu cho mỗi học sinh
        foreach ($studentIds as $studentId) {
            // Kế hoạch học tập cho hôm nay
            $studyPlans[] = [
                'student_id' => $studentId,
                'title' => 'Learn TOEIC',
                'day_of_week' => $today->format('l'), // Trả về tên của ngày trong tuần (Monday, Tuesday, ...)
                'date' => $today->format('Y-m-d'),
                'start_time' => '08:00:00',
                'end_time' => '09:30:00',
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
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Kế hoạch học tập cho ngày mai
            $studyPlans[] = [
                'student_id' => $studentId,
                'title' => 'Interview with mgm',
                'day_of_week' => $tomorrow->format('l'),
                'date' => $tomorrow->format('Y-m-d'),
                'start_time' => '08:00:00',
                'end_time' => '09:30:00',
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
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Kế hoạch học tập cho hôm qua
            $studyPlans[] = [
                'student_id' => $studentId,
                'title' => 'Practice Presentation',
                'day_of_week' => $yesterday->format('l'),
                'date' => $yesterday->format('Y-m-d'),
                'start_time' => '08:00:00',
                'end_time' => '09:30:00',
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
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        DB::table('study_plans')->insert($studyPlans);
    }
}