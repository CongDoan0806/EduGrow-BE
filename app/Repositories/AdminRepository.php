<?php
namespace App\Repositories;
use App\Models\Student;
use App\Models\Teacher;
use GuzzleHttp\Psr7\Request;

class AdminRepository{
    public function getAll(){
        return Student::all();
    }
    public function getAllTeacher(){
        return Teacher::all();
    }
    public function addUser(array $data){
        if ($data['role'] === 'student') {
            return Student::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone'=>$data['phone'],
                'password' => bcrypt($data['password']),
                'class_name' => $data['class_name']??null,
            ]);
        }

        if ($data['role'] === 'teacher') {
            return Teacher::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone'=>$data['phone'],
                'password' => bcrypt($data['password']),
                'subject' => $data['subject'] ?? null,
                
            ]);
        }

        throw new \Exception("Invalid role");
    }
   public function update($id, array $data)
    {

        if ($data['role'] === 'student') {
            $student = Student::where('student_id', $id)->firstOrFail();
            $student->update($data);
            return $student;
        }

        if ($data['role'] === 'teacher') {
            $teacher = Teacher::where('teacher_id', $id)->firstOrFail();
            $teacher->update($data);
            return $teacher;
        }

        throw new \Exception("Invalid role for update");
    }


    public function deleteUser($id, $role)
        {
            if ($role === 'student') {
                $student = Student::findOrFail($id);
                $student->delete();
            } elseif ($role === 'teacher') {
                $teacher = Teacher::findOrFail($id);
                $teacher->delete();
            } else {
                throw new \Exception("Invalid role");
            }
        }
}