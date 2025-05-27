<?php

namespace App\Services;

use App\Repositories\SemesterGoalRepository;
use App\Models\SemesterGoal;
use Illuminate\Support\Facades\Log;

class SemesterGoalService
{
    protected $semesterGoalRepository;
    protected $notificationService;

    public function __construct(
        SemesterGoalRepository $semesterGoalRepository,
        NotificationService $notificationService
    ) {
        $this->semesterGoalRepository = $semesterGoalRepository;
        $this->notificationService = $notificationService;
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
                    $goalContent = $this->semesterGoalRepository->createSemesterGoalContent([
                        'content' => $content['content'],
                        'reward' => $content['reward'] ?? null,
                        'status' => $content['status'] ?? 'pending',
                        'sg_id' => $semesterGoal->sg_id
                    ]);
                    // Tạo thông báo
                    $this->notificationService->createGoalNotification(
                        'goal_created',
                        $data['student_id'],
                        $data['subject_id'],
                        $goalContent->goal_id, // Sử dụng goal_id từ semester_goal_contents
                        $content['content']
                    );
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
        $goalContent = $this->semesterGoalRepository->updateSemesterGoalContent($goalId, $data);

        // Tạo thông báo
        if ($goalContent) {
            $semesterGoal = SemesterGoal::find($goalContent->sg_id); // Lấy thông tin semester_goal
            if ($semesterGoal) {
                 $this->notificationService->createGoalNotification(
                    'goal_updated',
                    $semesterGoal->student_id,
                    $semesterGoal->subject_id,
                    $goalContent->goal_id, // Sử dụng goal_id từ semester_goal_contents
                    $goalContent->content
                );
            }
        }

        return $goalContent;
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

            // Tạo thông báo
            if ($goalContent) {
                $semesterGoal = SemesterGoal::find($data['sg_id']); // Lấy thông tin semester_goal
                if ($semesterGoal) {
                    $this->notificationService->createGoalNotification(
                        'goal_created', // Hoặc 'goal_content_added' nếu bạn muốn phân biệt
                        $semesterGoal->student_id,
                        $semesterGoal->subject_id,
                        $goalContent->goal_id, // Sử dụng goal_id từ semester_goal_contents
                        $goalContent->content
                    );
                }
            }

            return $goalContent;
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm nội dung mục tiêu: ' . $e->getMessage());
            throw $e;
        }
    }
}