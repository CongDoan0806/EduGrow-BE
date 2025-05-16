<?php
namespace App\Repositories;

use App\Models\Student;
use App\Models\Subject;
use App\Models\StudyPlan;
use Carbon\Carbon;

class StudentRepository
{
    public function updateInfoText(Student $student, array $data)
    {
        $student->name = $data['name'];
        $student->phone = $data['phone'];
        $student->save();

        return $student;
    }

    public function updateAvatar(Student $student, string $avatarUrl)
    {
        $student->avatar = $avatarUrl;
        $student->save();

        return $student;
    }


    public function changePassword(Student $student, string $hashedPassword)
    {
        $student->password = $hashedPassword;
        $student->save();

        return $student;
    }
    public function getAllSubjects()
    {
        return Subject::all();
    }
    public function getTodayGoals(Student $student)
    {
        $today = Carbon::today();
        
        return StudyPlan::where('student_id', $student->student_id)
            ->whereDate('date', $today)
            ->orderBy('start_time')
            ->get(['plan_id as id', 'title', 'start_time', 'end_time', 'date']);
    }

 public function getStudyPlansByStudent($studentId)
{
    return StudyPlan::where('student_id', $studentId)
        ->orderBy('date')
        ->orderBy('start_time')
        ->get(['plan_id as id', 'title', 'start_time', 'end_time', 'date', 'color']);
}

    public function createStudyPlan(array $data)
    {
        return StudyPlan::create($data);
    }

    public function deleteStudyPlanById(int $id)
    {
        return StudyPlan::where('plan_id', $id)->delete();
    }
}
