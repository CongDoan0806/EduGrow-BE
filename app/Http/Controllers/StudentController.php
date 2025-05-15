<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'email' => 'required|email',
            'phone' => ['required', 'regex:/^(\+84|0)[3|5|7|8|9][0-9]{8}$/'],
            'avatar'=>'required|url',
        ]);

        $user = Auth::guard('student')->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        if ($user->name == $data['name'] && $user->email == $data['email'] && $user->phone == $data['phone'] && $user->avatar == $data['avatar']) {
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

        $user = Auth::guard('student')->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $this->studentService->changePassword($user, $data);

        return response()->json([
            'message' => 'Password has been changed successfully.',
        ]);
    }

    public function getLearningJournal(Request $request)
    {
        $user = Auth::guard('student')->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $studentId = $user->student_id; 
        $weekNumber = $request->query('week_number');

        try {
            $data = $this->studentService->getLearningJournal($studentId, $weekNumber);

            return response()->json([
                'message' => 'Learning journal retrieved successfully',
                'data' => $data,
                'week' => $weekNumber,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve learning journal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function saveLearningJournal(Request $request)
    {
        $user = Auth::guard('student')->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $studentId = $user->student_id;

        $weekNumber = $request->query('week_number');
        if (!isset($weekNumber) || !is_numeric($weekNumber)) {
            return response()->json(['message' => 'Invalid or missing week_number in URL'], 400);
        }
        $weekNumber = (int) $weekNumber;

        $data = $request->validate([
            'in_class' => 'sometimes|array',
            'in_class.*.date' => 'required_with:in_class|date',
            'in_class.*.skills_module' => 'required_with:in_class|string',
            'in_class.*.my_lesson' => 'required_with:in_class|string',
            'in_class.*.self_assessment' => 'required_with:in_class|string',
            'in_class.*.my_difficulties' => 'required_with:in_class|string',
            'in_class.*.my_plan' => 'required_with:in_class|string',
            'in_class.*.problem_solved' => 'required_with:in_class|boolean',
            'self_study' => 'sometimes|array',
            'self_study.*.date' => 'required_with:self_study|date',
            'self_study.*.skills_module' => 'required_with:self_study|string',
            'self_study.*.my_lesson' => 'required_with:self_study|string',
            'self_study.*.time_allocation' => 'required_with:self_study|string',
            'self_study.*.learning_resources' => 'required_with:self_study|string',
            'self_study.*.learning_activities' => 'required_with:self_study|string',
            'self_study.*.concentration' => 'required_with:self_study|boolean',
            'self_study.*.plan_follow' => 'required_with:self_study|boolean',
            'self_study.*.evaluation' => 'required_with:self_study|string',
            'self_study.*.reinforcing' => 'required_with:self_study|string',
            'self_study.*.notes' => 'required_with:self_study|string',
        ]);

        try {
            $data['week_number'] = $weekNumber;

            $this->studentService->saveLearningJournal($studentId, $data);

            $updatedData = $this->studentService->getLearningJournal($studentId, $weekNumber);

            return response()->json([
                'message' => 'Learning journal saved successfully',
                'data' => $updatedData,
                'week' => $weekNumber,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to save learning journal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getWeekDates($weekNumber)
    {
        $user = Auth::guard('student')->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $studentId = $user->student_id;
        
        // Gọi Service xử lý logic
        $result = $this->studentService->getWeekDates($studentId, (int)$weekNumber);

        return response()->json($result);
    }
}