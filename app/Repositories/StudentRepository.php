<?php
namespace App\Repositories;

use App\Models\Student;
use App\Models\StudyPlan;
use Carbon\Carbon;

class StudentRepository
{
    public function updateInfo(Student $student, array $data)
    {
        $student->name = $data['name'];
        $student->email = $data['email'];
        $student->phone = $data['phone'];
        $student->avatar = $data['avatar'];

        $student->save();

        return $student;
    }

    public function changePassword(Student $student, string $hashedPassword)
    {
        $student->password = $hashedPassword;
        $student->save();

        return $student;
    }

    public function getTodayGoals(Student $student)
    {
        $today = Carbon::today();
        
        return StudyPlan::where('student_id', $student->student_id)
            ->whereDate('date', $today)
            ->orderBy('start_time')
            ->get(['plan_id as id', 'title', 'start_time', 'end_time', 'date']);
    }
}
