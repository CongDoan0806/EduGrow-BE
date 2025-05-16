<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Services\StudentService;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

public function updateTextInfo(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string',
        'phone' => ['required', 'regex:/^(\+84|0)[3|5|7|8|9][0-9]{8}$/'],
    ]);

    $user = auth('student')->user();
    $updatedUser = $this->studentService->updateInfoText($user, $data);

    return response()->json([
        'message' => 'User text info updated successfully',
        'user' => $updatedUser,
    ], 200);
}

// Upload ảnh avatar dùng POST
public function uploadAvatar(Request $request)
{
    $data = $request->validate([
       'avatar' => 'nullable|file|image|max:5120'
    ]);

    $avatarFile = $request->file('avatar');

    $uploadedFileUrl = Cloudinary::upload($avatarFile->getRealPath(), [
        'folder' => 'avatars',
        'public_id' => uniqid('avatar_'),
        'overwrite' => true,
    ])->getSecurePath();

    $user = auth('student')->user();

    // Cập nhật avatar trong DB
    $updatedUser = $this->studentService->updateAvatar($user, $uploadedFileUrl);

    return response()->json([
        'message' => 'Avatar uploaded successfully',
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
    public function getTodayGoals()
    {
        $user = auth()->guard('student')->user();
        
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
        
        $goals = $this->studentService->getTodayGoals($user);
        
        return response()->json($goals);
    }
    public function getStudyPlans()
    {
        $user = auth()->guard('student')->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $plans = $this->studentService->getStudyPlans($user->student_id);

        return response()->json($plans);
    }

public function addStudyPlan(Request $request)
    {
        $user = auth()->guard('student')->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

       $data = $request->validate([
            'title' => 'required|string',
            'day_of_week' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s',
            'color' => ['required', 'string', 'regex:/^#([0-9a-fA-F]{6})$/'], // validate màu dạng #rrggbb
        ]);

        $data['student_id'] = $user->student_id;

        $plan = $this->studentService->createStudyPlan($data);

        return response()->json($plan, 201);
    }

public function deleteStudyPlan($id)
    {
        $user = auth()->guard('student')->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $this->studentService->deleteStudyPlan((int) $id);

        return response()->json(['message' => 'Study plan deleted successfully.']);
    }

}
