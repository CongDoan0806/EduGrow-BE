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
}