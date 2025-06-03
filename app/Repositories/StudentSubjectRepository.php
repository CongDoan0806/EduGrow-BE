<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class StudentSubjectRepository
{
    public function getStudentRating($studentId, $subjectId)
    {
        return DB::table('student_subject')
            ->select('student_id', 'subject_id', 'rating')
            ->where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->first();
    }

    public function saveRating($studentId, $subjectId, $rating)
    {
        return DB::table('student_subject')->updateOrInsert(
            [
                'student_id' => $studentId,
                'subject_id' => $subjectId,
            ],
            [
                'rating' => $rating,
                'updated_at' => now(),
            ]
        );
    }

    public function checkSubjectBelongsToTeacher($subjectId, $teacherId)
    {
        return DB::table('subjects')
            ->where('subject_id', $subjectId)
            ->where('teacher_id', $teacherId)
            ->exists();
    }
}
