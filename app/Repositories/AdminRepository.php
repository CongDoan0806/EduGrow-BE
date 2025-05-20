<?php
namespace App\Repositories;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassGroup;
use App\Models\Tag;
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

    public function countTeachers(): int
    {
        return Teacher::count();
    }

    public function countStudents(): int
    {
        return Student::count();
    }

    public function countClassGroups(): int
    {
        return ClassGroup::distinct('class_id')->count('class_id');
    }

    public function getStudentsPerClass(): array
    {
        return ClassGroup::select('class_name')
            ->selectRaw('COUNT(student_id) as student_count')
            ->groupBy('class_name')
            ->get()
            ->toArray();
    }

    public function getTopTaggedTeachers(int $limit = 3): array
    {
        return Tag::selectRaw('teachers.teacher_id, teachers.name, teachers.image, COUNT(tags.tag_id) as total_tags')
            ->join('teachers', 'tags.teacher_id', '=', 'teachers.teacher_id')
            ->groupBy('teachers.teacher_id', 'teachers.name', 'teachers.image')
            ->orderByDesc('total_tags')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}