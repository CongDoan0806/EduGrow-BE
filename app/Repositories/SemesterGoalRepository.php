<?php

namespace App\Repositories;

use App\Models\SemesterGoal;
use App\Models\SemesterGoalContent;
use App\Models\Subject;

class SemesterGoalRepository
{
    public function getSemesterGoalsByStudent($studentId)
    {
        return SemesterGoal::with(['contents', 'subject'])
            ->where('student_id', $studentId)
            ->get();
    }

    public function getSemesterGoalsBySubject($studentId, $subjectId)
    {
        return SemesterGoal::with('contents')
            ->where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->get();
    }

    public function createSemesterGoal(array $data)
    {
        return SemesterGoal::create($data);
    }

    public function createSemesterGoalContent(array $data)
    {
        return SemesterGoalContent::create($data);
    }

    public function updateSemesterGoalContent($goalId, array $data)
    {
        $goalContent = SemesterGoalContent::findOrFail($goalId);
        $goalContent->update($data);
        return $goalContent;
    }

    public function getSubjects()
    {
        return Subject::all();
    }
}