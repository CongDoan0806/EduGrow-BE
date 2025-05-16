<?php

namespace App\Http\Controllers;

use App\Services\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $AdminService;
    public function __construct(AdminService $adminService){
        $this->AdminService = $adminService;
    }
    public function showListStudent(){
        $student = $this->AdminService->getAllStudent();
        return response()->json([
            'success'=>true,
            'data'=>$student
        ]);
    }
    public function showListTeacher(){
        $teacher = $this->AdminService->getAllTeacher();
        return response()->json([
            'success'=>true,
            'data'=>$teacher
        ]);
    }
    public function add(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:students,email|unique:teachers,email',
            'role' => 'required|in:student,teacher',
            'phone' => 'required|string',
            'password'=>'required|string',
            'class_name'=>'nullable|string',
            'subject'=>'nullable|string'
        ]);

        try {
            $user = $this->AdminService->createUser($validated);
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

}
