<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Services\TeacherService;
use Illuminate\Support\Facades\Auth;
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

    public function getTeacherClasses(Request $request)
    {
        try {
            $teacher = auth()->guard('teacher')->user();
            if (!$teacher) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $classes = $this->teacherService->getClassesByTeacherId($teacher->teacher_id);
            return response()->json([
                'success' => true,
                'classes' => $classes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching classes: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createFeedback(Request $request)
    {
        $user = auth()->guard('teacher')->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $validatedData = $request->validate([
            'tag_id' => 'required|integer|exists:tags,tag_id',
            'content' => 'required|string|max:255',
        ]);
        $validatedData['teacher_id'] = $user->teacher_id;
        $feedback = $this->teacherService->createFeedback($validatedData);

        return response()->json($feedback, 201);
    }
    
    public function dashboard(Request $request)
    {
        $teacher = auth()->guard('teacher')->user();

        if (!$teacher) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            $data = $this->teacherService->getDashboardData($teacher->teacher_id);
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getStudentsBySubject(Request $request)
    {
        $teacher = auth()->guard('teacher')->user();

        if (!$teacher) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $subjectId = $request->query('subject_id');

        if ($subjectId) {
            $students = $this->teacherService->getStudentsBySubject($teacher->teacher_id, $subjectId);
        } else {
            $students = $this->teacherService->getStudentsBySubject($teacher->teacher_id);
        }

        return response()->json(['success' => true, 'data' => $students]);
    }

    

    public function getSubjects(Request $request)
    {
        $teacher = auth()->guard('teacher')->user();
        if (!$teacher) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $subjects = $this->teacherService->getSubjectsByTeacher($teacher->teacher_id);

        return response()->json([
            'success' => true,
            'data' => $subjects
        ]);
    }
    public function getCombinedNotifications(Request $request)
    {
        $teacherId = $request->query('teacher_id');
        
        if (!$teacherId) {
            return response()->json(['error' => 'Teacher ID is required'], 400);
        }

        $notifications = $this->teacherService->getCombinedNotifications($teacherId);
        return response()->json($notifications);
    }
    public function markNotificationsAsRead(Request $request)
    {
        $teacherId = $request->user()->id; 
        $notificationIds = $request->input('notification_ids');

        if (!$notificationIds || !is_array($notificationIds)) {
            return response()->json(['error' => 'notification_ids is required and must be an array'], 400);
        }

        Notification::where('recipient_role', 'teacher')
            ->where('teacher_id', $teacherId)
            ->whereIn('id', $notificationIds)
            ->update(['is_read' => true]);

        return response()->json(['message' => 'Notifications marked as read']);
    }

    
}

    

