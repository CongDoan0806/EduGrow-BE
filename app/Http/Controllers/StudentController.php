<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StudentService;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function updateInfo(Request $request)
        {
            $data = $request->validate([
                'name' => 'required|string',
                'phone' => ['required', 'regex:/^(\+84|0)[3|5|7|8|9][0-9]{8}$/'],
               'avatar' => 'nullable|string'
            ]);


            $user = auth()->guard('student')->user();

            if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }

            if ($user->name == $data['name'] && $user->phone == $data['phone'] && $user->avatar == $data['avatar']) {
                return response()->json([
                    'message' => 'No changes made.',
                ], 200);
                
            }

            $updatedUser = $this->studentService->updateInfo($user, $data);

            return response()->json([
                'message' => 'User information updated successfully',
                'user' => $updatedUser,
            ], 200);
        }


    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = auth()->guard('student')->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $this->studentService->changePassword($user, $data);

        return response()->json([
            'message' => 'Password has been changed successfully.',
        ]);
    }

    public function showInfo(Request $request)
    {
        return response()->json($request->user());
    }

    public function showSubjects()
    {  
        $subjects = $this->studentService->getAllSubjects();

        return response()->json([
            'subjects' => $subjects,
        ], 200);
    }
}
