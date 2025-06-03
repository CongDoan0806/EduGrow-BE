<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\StudentSubjectService;

class StudentSubjectController extends Controller
{
    protected $studentSubjectService;

    public function __construct(StudentSubjectService $studentSubjectService)
    {
        $this->studentSubjectService = $studentSubjectService;
    }

    public function rateStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,student_id',
            'subject_id' => 'required|exists:subjects,subject_id',
            'rating' => 'required|in:good,ok,bad',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $teacherId = auth()->user()->teacher_id;

        try {
            $this->studentSubjectService->rateStudent(
                $request->student_id,
                $request->subject_id,
                $teacherId,
                $request->rating
            );

            return response()->json([
                'success' => true,
                'message' => 'Rating saved successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 403);
        }
    }
    
 public function getStudentRating(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:students,student_id',
        'subject_id' => 'required|exists:subjects,subject_id',
    ]);

    $studentId = $request->student_id;
    $subjectId = $request->subject_id;

    $rating = $this->studentSubjectService->getStudentRating($studentId, $subjectId);

    if (!$rating) {
        return response()->json([
            'success' => false,
            'message' => 'Rating not found',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $rating,
    ]);
}

}
