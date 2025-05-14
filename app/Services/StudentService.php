<?php
namespace App\Services;

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

    public function updateInfo($student, array $data)
    {
        return $this->studentRepository->updateInfo($student, data: $data);
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
}
