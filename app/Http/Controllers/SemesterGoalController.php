<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SemesterGoalService;
use Illuminate\Support\Facades\Log;

class SemesterGoalController extends Controller
{
    protected $semesterGoalService;

    public function __construct(SemesterGoalService $semesterGoalService)
    {
        $this->semesterGoalService = $semesterGoalService;
    }

    public function getSemesterGoals(Request $request)
    {
        try {
            $studentId = auth()->user()->student_id;
            $subjectId = $request->query('subject_id');

            if ($subjectId) {
                $goals = $this->semesterGoalService->getSemesterGoalsBySubject($studentId, $subjectId);
            } else {
                $goals = $this->semesterGoalService->getSemesterGoalsByStudent($studentId);
            }

            return response()->json([
                'success' => true,
                'data' => $goals
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy semester goals: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy dữ liệu',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function createSemesterGoal(Request $request)
    {
        try {
            $validated = $request->validate([
                'subject_id' => 'required|exists:subjects,subject_id',
                'semester' => 'required|string',
                'deadline' => 'required|date',
                'contents' => 'required|array',
                'contents.*.content' => 'required|string',
                'contents.*.reward' => 'nullable|string',
            ]);

            $validated['student_id'] = auth()->user()->student_id;

            $goal = $this->semesterGoalService->createSemesterGoal($validated);

            return response()->json([
                'success' => true,
                'data' => $goal
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo semester goal: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tạo mục tiêu',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateGoalContent(Request $request, $goalId)
    {
        try {
            $validated = $request->validate([
                'content' => 'nullable|string',
                'reward' => 'nullable|string',
                'status' => 'nullable|in:pending,completed,failed',
                'reflect' => 'nullable|string',
            ]);

            $goalContent = $this->semesterGoalService->updateSemesterGoalContent($goalId, $validated);

            return response()->json([
                'success' => true,
                'data' => $goalContent
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật nội dung mục tiêu: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật nội dung mục tiêu',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getSubjects()
    {
        try {
            $subjects = $this->semesterGoalService->getSubjects();
            
            return response()->json([
                'success' => true,
                'data' => $subjects
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy danh sách môn học: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy danh sách môn học',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function addGoalContent(Request $request)
{
    try {
        $validated = $request->validate([
            'content' => 'required|string',
            'reward' => 'nullable|string',
            'status' => 'nullable|in:pending,completed,failed',
            'sg_id' => 'required|exists:semester_goals,sg_id',
        ]);

        $goalContent = $this->semesterGoalService->addSemesterGoalContent($validated);

        return response()->json([
            'success' => true,
            'data' => $goalContent
        ], 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        Log::error('Lỗi khi thêm nội dung mục tiêu: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi thêm nội dung mục tiêu',
            'error' => $e->getMessage()
        ], 500);
    }
}
}