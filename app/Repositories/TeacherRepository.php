<?php

namespace App\Repositories;

use App\Models\LearningJournalClass;
use App\Models\Tag;
use App\Models\TagReplies;
use App\Models\Teacher;

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
}