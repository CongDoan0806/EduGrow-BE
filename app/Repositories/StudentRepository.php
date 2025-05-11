<?php
namespace App\Repositories;

use App\Models\Student;

class StudentRepository
{
    public function updateInfo(Student $student, array $data)
    {
        $student->name = $data['name'];
        $student->email = $data['email'];
        $student->phone = $data['phone'];
        $student->avatar = $data['avatar'];

        $student->save();

        return $student;
    }

    public function changePassword(Student $student, string $hashedPassword)
    {
        $student->password = $hashedPassword;
        $student->save();

        return $student;
    }
}
