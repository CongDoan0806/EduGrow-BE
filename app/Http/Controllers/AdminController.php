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
}
