<?php
namespace App\Services;

use App\Models\Student;
use App\Repositories\StudyPlanRepository;

class StudyPlanService{
    protected $studyPlanRepository;

    public function __construct(StudyPlanRepository $studyPlanRepository)
    {
        $this->studyPlanRepository = $studyPlanRepository;
    }

    public function getTodayGoals(Student $student)
    {
        return $this->studyPlanRepository->getTodayGoals($student);
    }
}
