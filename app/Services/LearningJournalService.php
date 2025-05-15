<?php
namespace App\Services;

use App\Repositories\LearningJournalRepository;

class LearningJournalService
{
    protected $repo;

    public function __construct(LearningJournalRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getClassLearningJournalsByStudentAndTeacher($studentId, $teacherId, $weekNumber = null)
    {
        if (!$weekNumber) {
            $weekNumber = $this->repo->getCurrentWeekNumber($studentId);
        }
        return $this->repo->getClassLearningJournalsByStudentAndTeacher($teacherId, $studentId, $weekNumber);
    }

    public function getSelfLearningJournalsByStudentAndTeacher($studentId, $teacherId, $weekNumber = null)
    {
        if (!$weekNumber) {
            $weekNumber = $this->repo->getCurrentWeekNumber($studentId);
        }
        return $this->repo->getSelfLearningJournalsByStudentAndTeacher($teacherId, $studentId, $weekNumber);
    }
    public function getTagByLearningJournalId($learningJournalId)
    {
        return $this->repo->getTagByLearningJournalId($learningJournalId);
    }

}
