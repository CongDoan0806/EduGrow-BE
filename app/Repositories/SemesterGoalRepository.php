<?php

namespace App\Repositories;

use App\Models\SemesterGoal;
use App\Models\SemesterGoalContent;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

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

    public function getSemesterGoalsByStudentId($studentId, $teacherId)
    {
        return DB::table('semester_goals as sg')
            ->join('semester_goal_contents as sgc', 'sg.sg_id', '=', 'sgc.sg_id')
            ->join('subjects as s', 's.subject_id', '=', 'sg.subject_id')
            ->join('students as st', 'st.student_id', '=', 'sg.student_id')
            ->where('sg.student_id', $studentId)
            ->where('s.teacher_id', $teacherId)
            ->select(
                'sg.sg_id',
                'sg.semester',
                'sg.deadline',
                'sgc.goal_id',
                'sgc.content',
                'sgc.reward',
                'sgc.status',
                'sgc.reflect',
                's.name',
                'st.name as student_name',
                'st.email as student_email',
                'sgc.teacher_feedback'
            )
            ->get();
    }
    public function setDeadlineByGoalId($goalId, $deadline)
    {
        $goal = SemesterGoal::findOrFail($goalId);
        $goal->deadline = $deadline;
        $goal->save();
        return $goal;
    }

public function setFeedbackByGoalId($goalId, $feedback)
{
    $goalContent = SemesterGoalContent::findOrFail($goalId);
    $goalContent->teacher_feedback = $feedback;
    $goalContent->save();

    $goalContent->refresh();

    return $goalContent;
}

}