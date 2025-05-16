<?php

namespace App\Services;

use App\Repositories\SemesterGoalRepository;

class SemesterGoalService
{
    protected $semesterGoalRepository;

    public function __construct(SemesterGoalRepository $semesterGoalRepository)
    {
        $this->semesterGoalRepository = $semesterGoalRepository;
    }

    public function getSemesterGoalsByStudent($studentId)
    {
        return $this->semesterGoalRepository->getSemesterGoalsByStudent($studentId);
    }

    public function getSemesterGoalsBySubject($studentId, $subjectId)
    {
        return $this->semesterGoalRepository->getSemesterGoalsBySubject($studentId, $subjectId);
    }

    public function createSemesterGoal(array $data)
    {
        $semesterGoal = $this->semesterGoalRepository->createSemesterGoal([
            'student_id' => $data['student_id'],
            'subject_id' => $data['subject_id'],
            'semester' => $data['semester'],
            'deadline' => $data['deadline']
        ]);

        if (isset($data['contents']) && is_array($data['contents'])) {
            foreach ($data['contents'] as $content) {
                $this->semesterGoalRepository->createSemesterGoalContent([
                    'content' => $content['content'],
                    'reward' => $content['reward'] ?? null,
                    'status' => $content['status'] ?? 'pending',
                    'sg_id' => $semesterGoal->sg_id
                ]);
            }
        }

        return $semesterGoal;
    }

    public function updateSemesterGoalContent($goalId, array $data)
    {
        return $this->semesterGoalRepository->updateSemesterGoalContent($goalId, $data);
    }

    public function getSubjects()
    {
        return $this->semesterGoalRepository->getSubjects();
    }
}