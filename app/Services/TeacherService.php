<?php

namespace App\Services;

use App\Repositories\TeacherRepository;

class TeacherService
{
    protected $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function getAllTeachers()
    {
        return $this->teacherRepository->getAllTeachers();
    }

    public function getTeacherById($id)
    {
        return $this->teacherRepository->getTeacherById($id);
    }

    public function createFeedback(array $data)
    {
        return $this->teacherRepository->createFeedback($data);
    }
    
    
    public function getClassesByTeacherId($teacherId)
    {
        return $this->teacherRepository->getClassesByTeacherId($teacherId);
    }

    public function getDashboardData($teacherId)
    {
        $teacher = $this->teacherRepository->getTeacherWithSubjects($teacherId);

        if (!$teacher) {
            throw new \Exception("Teacher not found");
        }

        $subjects = $teacher->subjects;
        return [
            'class_count' => $subjects->count(),
            'student_count' => $subjects->sum(function ($subject) {
                return $subject->student_subject_count ?? 0;
            }),
            'subjects' => $subjects,
        ];
    }

    public function getStudentsBySubject($teacherId, $subjectId = null)
    {
        if ($subjectId) {
            return $this->teacherRepository->getStudentsBySubject($teacherId, $subjectId);
        } else {
            return $this->teacherRepository->getAllStudentsByTeacher($teacherId);
        }
    }


    public function getSubjectsByTeacher($teacherId)
    {
        return $this->teacherRepository->getSubjectsByTeacher($teacherId);
    }
    public function getCombinedNotifications($teacherId)
    {
        $tags = $this->teacherRepository->getMentionByTeacher($teacherId)
            ->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'message' => $tag->message,
                    'student' => $tag->student,
                    'type' => 'tag',
                    'created_at' => $tag->created_at,
                    'is_read' => $tag->is_read,
                ];
            });

        $notifications = $this->teacherRepository->getNotificationTeacher($teacherId)
            ->map(function ($noti) {
                return [
                    'id' => $noti->id,
                    'message' => $noti->message,
                    'type' => 'notification',
                    'created_at' => $noti->created_at,
                    'is_read' => $noti->is_read,
                ];
            });

        return $tags->merge($notifications)->sortByDesc('created_at')->values();
    }


}