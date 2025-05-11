<?php

namespace App\Repositories;

use App\Models\Student;
use App\Models\StudyPlan;
use Carbon\Carbon;

class StudyPlanRepository
{
    public function getTodayGoals(Student $student)
    {
        $today = Carbon::today();
        
        return StudyPlan::where('student_id', $student->student_id)
            ->whereDate('date', $today)
            ->orderBy('start_time')
            ->get(['plan_id as id', 'title', 'start_time', 'end_time', 'date']);
    }
}