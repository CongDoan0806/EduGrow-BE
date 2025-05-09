<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Admin;

class AuthRepository
{
    public function findUserByEmail(string $email): ?array
    {
        $student = Student::where('email', $email)->first();
        if ($student) {
            return ['user' => $student, 'role' => 'student'];
        }

        $teacher = Teacher::where('email', $email)->first();
        if ($teacher) {
            return ['user' => $teacher, 'role' => 'teacher'];
        }

        $admin = Admin::where('email', $email)->first();
        if ($admin) {
            return ['user' => $admin, 'role' => 'admin'];
        }

        return null;
    }

    public function validatePassword($user, $password): bool
    {
        return Hash::check($password, $user->password);
    }
}
