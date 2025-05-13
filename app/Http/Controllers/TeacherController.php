<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TeacherService;

class TeacherController extends Controller
{
    protected $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function index()
    {
        $teachers = $this->teacherService->getAllTeachers();
        return response()->json($teachers);
    }

    public function show($id)
    {
        $teacher = $this->teacherService->getTeacherById($id);
        
        if (!$teacher) {
            return response()->json(['message' => 'Không tìm thấy giáo viên'], 404);
        }
        
        return response()->json($teacher);
    }

    public function createFeedback(Request $request)
    {
        $user = auth()->guard('teacher')->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $validatedData = $request->validate([
            'learning_journal_id' => 'required|integer|exists:learning_journal,learning_journal_id',
            'message' => 'required|string|max:255',
        ]);

        $validatedData['teacher_id'] = $user->teacher_id;
        $feedback = $this->teacherService->createFeedback($validatedData);

        return response()->json($feedback, 201);
    }
}