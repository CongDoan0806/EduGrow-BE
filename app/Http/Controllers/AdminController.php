<?php

namespace App\Http\Controllers;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
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
    public function getAllClasses(){
        $user = auth()->guard('admin')->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $classes = $this->AdminService->getAllClasses();
        return response()->json([
            'classes' => $classes
        ]);
            
    }
    
    public function addClass(Request $request)
    {   
        $user = auth()->guard('admin')->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'teacher_id' => 'required|exists:teachers,teacher_id',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:students,student_id',
            'img' => 'nullable',
 
        ]);

        if ($request->hasFile('img')) {
            $imageFile = $request->file('img');
            $uploadedFileUrl = Cloudinary::upload($imageFile->getRealPath(), ['folder' => 'classAvatar', 'public_id' => 'class_' . uniqid(),])->getSecurePath();

            $data['img'] = $uploadedFileUrl;
        } elseif (isset($data['img']) && filter_var($data['img'], FILTER_VALIDATE_URL)) {
            $data['img'] = $data['img']; 
        }

        $this->AdminService->createClass($data);

        return response()->json(['message' => 'Class created successfully']);
    }
            
    

}
