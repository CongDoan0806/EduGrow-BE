<?php

namespace App\Repositories;

use App\Models\LearningJournalClass;
use App\Models\Tag;
use App\Models\TagReplies;
use App\Models\Teacher;
use  App\Models\Notification;
use App\Models\Subject;
use App\Models\Student;

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

    public function getClassesByTeacherId($teacherId)
    {
        return Subject::where('teacher_id', $teacherId)
            ->get()
            ->map(function ($subject) {
                return [
                    'class_id' => $subject->subject_id, 
                    'subject_name' => $subject->subject_name,
                    'subject_img' => $subject->image_url,
                    'description' => $subject->description,
                    'student_count' => $subject->studentSubject()->count()
                ];
            });
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
      public function getStudentsBySubject($teacherId, $subjectId)
    {
        $subject = Subject::where('teacher_id', $teacherId)
            ->where('subject_id', $subjectId)
            ->first();

        if (!$subject) {
            return null;
        }

        return Student::whereHas('studentSubject', function ($query) use ($subjectId) {
            $query->where('subject_id', $subjectId);
        })
            ->with(['studentSubject' => function ($query) use ($subjectId) {
                $query->where('subject_id', $subjectId);
            }])
            ->get();
    }

  public function getAllStudentsByTeacher($teacherId)
{
    return Student::whereHas('studentSubject.subject', function ($query) use ($teacherId) {
        $query->where('teacher_id', $teacherId);
    })->get();
}


    public function getSubjectsByTeacher($teacherId)
    {
        return Subject::where('teacher_id', $teacherId)
            ->select('subject_id as id', 'name')
            ->get();
    }
}