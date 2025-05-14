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
    if (isset($data['avatar']) && $this->isBase64Image($data['avatar'])) {
        $data['avatar'] = $this->saveBase64Image($data['avatar']);
    }

    return $this->studentRepository->updateInfo($student, $data);
}

private function isBase64Image($data)
{
    return preg_match('/^data:image\/(\w+);base64,/', $data);
}

private function saveBase64Image($base64Image)
{
    if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
        $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
        $type = strtolower($type[1]); // jpg, png, etc.

        $imageData = base64_decode($base64Image);
        if ($imageData === false) {
            throw new \Exception('base64_decode failed');
        }

        $filename = uniqid() . '.' . $type;
        $path = public_path('uploads/avatars/' . $filename);
        file_put_contents($path, $imageData);

        return 'uploads/avatars/' . $filename;
    }

    return null;
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