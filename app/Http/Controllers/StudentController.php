<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Services\StudentService;
use App\Models\Subject;
use App\Models\LearningJournal;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function showInfo(Request $request)
    {
        return response()->json($request->user());
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
     public function getSubjectsAndComments(Request $request)
    {
        $user = Auth::guard('student')->user();
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $studentId = $user->student_id;
        $weekNumber = $request->query('week_number');
        if (!$weekNumber) {
            return response()->json(['message' => 'week_number is required'], 400);
        }

        $data = $this->studentService->getSubjectsAndComments($studentId, $weekNumber);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'learning_journal_id' => 'required|exists:learning_journal,learning_journal_id',
            'teacher_id' => 'required|exists:teachers,teacher_id',
            'message' => 'required|string',
        ]);

        $user = Auth::guard('student')->user();
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $studentId = $user->student_id;
        $exists = LearningJournal::where('learning_journal_id', $validated['learning_journal_id'])
            ->whereHas('studentSubject', function ($q) use ($studentId) {
                $q->where('student_id', $studentId);
            })->exists();

        if (!$exists) {
            return response()->json(['message' => 'Invalid learning_journal_id for this student'], 403);
        }

        $weekNumber = $request->query('week_number');
        if (!$weekNumber) {
            return response()->json(['message' => 'week_number is required'], 400);
        }

        $tagData = array_merge($validated, [
            'student_id' => $studentId,
            'created_at' => now(), 
        ]);

        $savedTag = $this->studentService->storeTag($tagData);

        $tags = $this->studentService->getTagsByLearningJournalAndWeek($validated['learning_journal_id'], $weekNumber);

        return response()->json([
            'saved_tag' => $savedTag,
            'all_tags_in_week' => $tags,
        ]);
    }

    public function getTeachersBySubject(Request $request)
    {
        $user = Auth::guard('student')->user();
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $subjectId = $request->query('subject_id');
        if (!$subjectId) {
            return response()->json(['message' => 'subject_id is required'], 400);
        }

        $subject = Subject::with('teachers')->find($subjectId);
        if (!$subject) {
            return response()->json(['message' => 'Subject not found'], 404);
        }

       $teacher = $subject->teachers;

        if (!$teacher) {
            return response()->json(['message' => 'Teacher not found for this subject'], 404);
        }

        $data = [
            'teacher_id' => $teacher->teacher_id,
            'name' => $teacher->name,
        ];

        return response()->json(['teacher' => $data]);
    }
    public function getNotifications(Request $request)
    {
        $studentId = $request->query('student_id');

        if (!$studentId) {
            return response()->json(['error' => 'Student ID is required'], 400);
        }

        $notifications = $this->studentService->getNotificationByStudent($studentId);

        return response()->json($notifications);
    }


    public function uploadAchievement(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_achieved' => 'required|date',
            'file' => 'nullable|file|image|max:5120',
        ]);

        $filePath = null;

        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');

            $filePath = Cloudinary::upload($uploadedFile->getRealPath(), [
                'folder' => 'achievements',
                'public_id' => uniqid('achievement_'),
                'overwrite' => true,
            ])->getSecurePath();
        }

        $student = auth('student')->user();

        $achievement = $this->studentService->uploadAchievement([
            'student_id' => $student->student_id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'file_path' => $filePath,
            'date_achieved' => $data['date_achieved'],
            'uploaded_at' => now(),
        ]);

        return response()->json([
            'message' => 'Achievement uploaded successfully.',
            'data' => $achievement,
        ], 201);
    }

    public function getAchievements(Request $request)
    {
        $student = auth('student')->user();
        if (!$student) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $notifications = $this->studentService->getNotificationByStudent($student->id);
        return response()->json($notifications);
        $achievements = $this->studentService->getAchievementsByStudent($student->student_id);

        return response()->json([
            'achievements' => $achievements->map(function ($achievement) {
                return [
                    'achievement_id' => $achievement->achievement_id,
                    'title' => $achievement->title,
                    'description' => $achievement->description,
                    'file_path' => $achievement->file_path,
                    'date_achieved' => $achievement->date_achieved,
                ];
            }),
        ]);
    }
}

