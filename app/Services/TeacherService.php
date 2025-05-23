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
    public function getTags($teacherId){
        return $this->teacherRepository->getMentionByTeacher($teacherId);
    }
}