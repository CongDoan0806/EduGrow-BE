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

}