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
}