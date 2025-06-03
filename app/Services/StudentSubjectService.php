<?php

namespace App\Services;

use App\Repositories\StudentSubjectRepository;

class StudentSubjectService
{
    protected $studentSubjectRepository;

    public function __construct(StudentSubjectRepository $studentSubjectRepository)
    {
        $this->studentSubjectRepository = $studentSubjectRepository;
    }

    public function rateStudent($studentId, $subjectId, $teacherId, $rating)
    {
        if (!$this->studentSubjectRepository->checkSubjectBelongsToTeacher($subjectId, $teacherId)) {
            throw new \Exception("You do not have permission to rate this subject.");
        }

        return $this->studentSubjectRepository->saveRating($studentId, $subjectId, $rating);
    }

    public function getStudentRating($studentId, $subjectId)
    {
        return $this->studentSubjectRepository->getStudentRating($studentId, $subjectId);
    }
}
