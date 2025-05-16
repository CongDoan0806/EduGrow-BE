<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SemesterGoalService;

class SemesterGoalController extends Controller
{
    protected $semesterGoalService;

    public function __construct(SemesterGoalService $semesterGoalService)
    {
        $this->semesterGoalService = $semesterGoalService;
    }

    public function getSemesterGoals(Request $request)
    {
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
    }

    public function createSemesterGoal(Request $request)
    {
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
    }

    public function updateGoalContent(Request $request, $goalId)
    {
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
    }

    public function getSubjects()
    {
        $subjects = $this->semesterGoalService->getSubjects();
        
        return response()->json([
            'success' => true,
            'data' => $subjects
        ]);
    }
}