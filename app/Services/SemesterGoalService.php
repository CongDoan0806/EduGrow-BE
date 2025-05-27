<?php

namespace App\Services;

use App\Repositories\SemesterGoalRepository;
use Illuminate\Support\Facades\Log;

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
        try {
            // Tạo semester goal
            $semesterGoal = $this->semesterGoalRepository->createSemesterGoal([
                'student_id' => $data['student_id'],
                'subject_id' => $data['subject_id'],
                'semester' => $data['semester'],
                'deadline' => $data['deadline'],
                'created_at' => now()
            ]);

            // Tạo các nội dung mục tiêu
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

            // Lấy semester goal với các nội dung đã tạo
            return $this->semesterGoalRepository->getSemesterGoalsBySubject($data['student_id'], $data['subject_id']);
        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo semester goal: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateSemesterGoalContent($goalId, array $data)
    {
        return $this->semesterGoalRepository->updateSemesterGoalContent($goalId, $data);
    }

    public function getSubjects()
    {
        return $this->semesterGoalRepository->getSubjects();
    }

    public function addSemesterGoalContent(array $data)
{
    try {
        $goalContent = $this->semesterGoalRepository->createSemesterGoalContent([
            'content' => $data['content'],
            'reward' => $data['reward'] ?? null,
            'status' => $data['status'] ?? 'pending',
            'sg_id' => $data['sg_id']
        ]);

        return $goalContent;
    } catch (\Exception $e) {
        Log::error('Lỗi khi thêm nội dung mục tiêu: ' . $e->getMessage());
        throw $e;
    }
}
}