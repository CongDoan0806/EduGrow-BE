<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Tạo notification cho goal (tạo mới hoặc cập nhật)
     */
    public function createGoalNotification($type, $studentId, $subjectId, $goalId, $goalContent)
    {
        try {
            $student = Student::find($studentId);
            $subject = Subject::find($subjectId);
            
            $message = '';
            if ($type === 'goal_created') {
                $message = "Sinh viên {$student->name} đã tạo mục tiêu mới: '{$goalContent}' cho môn {$subject->subject_name}";
            } elseif ($type === 'goal_updated') {
                $message = "Sinh viên {$student->name} đã cập nhật mục tiêu: '{$goalContent}' cho môn {$subject->subject_name}";
            }
            
            // Tìm giáo viên dạy môn này để gửi thông báo
            $teacherId = $subject->teacher_id ?? null;
            
            return Notification::create([
                'type' => $type,
                'message' => $message,
                'student_id' => $studentId,
                'teacher_id' => $teacherId,
                'subject_id' => $subjectId,
                'goal_id' => $goalId,
                'is_read' => false
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo goal notification: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Tạo notification khi sinh viên tag giáo viên
     */
    public function createTagNotification($tagId, $studentId, $teacherId, $message)
    {
        try {
            $student = Student::find($studentId);
            $teacher = Teacher::find($teacherId);
            
            $notificationMessage = "Sinh viên {$student->name} đã tag bạn trong một comment: '{$message}'";
            
            return Notification::create([
                'type' => 'student_tagged',
                'message' => $notificationMessage,
                'student_id' => $studentId,
                'teacher_id' => $teacherId,
                'tag_id' => $tagId,
                'is_read' => false
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo tag notification: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Tạo notification khi giáo viên phản hồi tag
     */
    public function createReplyNotification($replyId, $tagId, $teacherId, $studentId, $replyContent)
    {
        try {
            $teacher = Teacher::find($teacherId);
            $student = Student::find($studentId);
            
            $notificationMessage = "Giáo viên {$teacher->name} đã phản hồi tag của bạn: '{$replyContent}'";
            
            return Notification::create([
                'type' => 'teacher_replied',
                'message' => $notificationMessage,
                'student_id' => $studentId,
                'teacher_id' => $teacherId,
                'tag_id' => $tagId,
                'reply_id' => $replyId,
                'is_read' => false
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo reply notification: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Lấy notifications cho giáo viên
     */
    public function getNotificationsForTeacher($teacherId, $limit = 20)
    {
        return Notification::forTeacher($teacherId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Lấy notifications cho sinh viên
     */
    public function getNotificationsForStudent($studentId, $limit = 20)
    {
        return Notification::forStudent($studentId)
            ->whereIn('type', ['teacher_replied']) // Sinh viên chỉ nhận thông báo reply
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Đánh dấu notification đã đọc
     */
    public function markAsRead($notificationId)
    {
        return Notification::where('id', $notificationId)
            ->update(['is_read' => true]);
    }

    /**
     * Đếm số notification chưa đọc
     */
    public function getUnreadCount($userId, $userType = 'teacher')
    {
        $query = Notification::where('is_read', false);
        
        if ($userType === 'teacher') {
            $query->where('teacher_id', $userId);
        } else {
            $query->where('student_id', $userId)
                  ->where('type', 'teacher_replied');
        }
        
        return $query->count();
    }
}