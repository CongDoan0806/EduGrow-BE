<?php
namespace App\Services;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Repositories\StudentRepository;


class StudentService
{
    protected $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

   public function updateInfoText($student, array $data)
    {
        // Cập nhật name, phone
        $student->name = $data['name'];
        $student->phone = $data['phone'];
        $student->save();

        return $student;
    }

    public function updateAvatar($student, string $avatarUrl)
    {
        $student->avatar = $avatarUrl;
        $student->save();

        return $student;
    }

   
    public function changePassword($student, array $data)
    {
        if (!Hash::check($data['current_password'], $student->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Current password is incorrect'],
            ]);
        }

        $hashedPassword = Hash::make($data['new_password']);

        return $this->studentRepository->changePassword($student, $hashedPassword);
    }
    public function getAllSubjects()
    {
        return $this->studentRepository->getAllSubjects();
    }

    public function getTodayGoals(Student $student)
    {
        return $this->studentRepository->getTodayGoals($student);
    }

    public function getStudyPlans(int $studentId)
    {
        return $this->studentRepository->getStudyPlansByStudent($studentId);
    }

    public function createStudyPlan(array $data)
    {
        return $this->studentRepository->createStudyPlan($data);
    }

    public function deleteStudyPlan(int $id)
    {
        return $this->studentRepository->deleteStudyPlanById($id);
    }
}

