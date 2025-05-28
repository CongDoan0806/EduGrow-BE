<?php

namespace App\Repositories;

use App\Models\LearningJournalClass;
use App\Models\Tag;
use App\Models\TagReplies;
use App\Models\Teacher;
use  App\Models\Notification;

class TeacherRepository
{
    protected $model;

    public function __construct(Teacher $teacher)
    {
        $this->model = $teacher;
    }

    public function getAllTeachers()
    {
        return $this->model->select('teacher_id as id', 'name', 'title', 'image', 'facebook', 'linkedin', 'twitter')
            ->get();
    }

    public function getTeacherById($id)
    {
        return $this->model->select('teacher_id as id', 'name', 'title', 'image', 'facebook', 'linkedin', 'twitter')
            ->where('teacher_id', $id)
            ->first();
    }
    public function createFeedback(array $data)
    {
        return TagReplies::create($data);
    }
    public function getMentionByTeacher($teacherId){
        return Tag::with('student')
        ->where('teacher_id',$teacherId)
        ->orderBy('created_at', 'desc')
        ->get();
    }

    public function getNotificationsByTeacher($teacherId)
    {
        return Notification::with('student')
            ->where('teacher_id', $teacherId)
            ->orWhere(function ($query) use ($teacherId) {
                $query->whereNull('student_id')
                      ->where('teacher_id', $teacherId);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public function getTeacherWithSubjects($teacherId)
    {
        return Teacher::with(['subjects' => function($query) {
            $query->withCount('studentSubject');
        }])->find($teacherId);
    }

}