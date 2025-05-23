<?php
namespace App\Repositories;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\StudentSubject;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

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
    public function getAllClasses(){
        return DB::table('subjects as s')
            ->join('teachers as t', 's.teacher_id', '=', 't.teacher_id')
            ->leftJoin('student_subject as ss', 'ss.subject_id', '=', 's.subject_id')
            ->select(
                's.subject_id',
                's.name as subject_name',
                's.description',
                's.img as subject_img',
                't.name as teacher_name',
                't.avatar as teacher_avatar',
                DB::raw('COUNT(ss.student_id) as student_count')
            )
            ->groupBy('s.subject_id', 's.name', 's.description', 's.img', 't.name', 't.avatar')
            ->get();
    }

        public function createClass(array $data)
    {
        $subject = Subject::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'teacher_id' => $data['teacher_id'],
            'img' => $data['img'] ?? null,
        ]);
        $subjectId = $subject->subject_id;
        foreach ($data['student_ids'] as $studentId) {
            StudentSubject::create([
                'student_id' => $studentId,
                'subject_id' => $subjectId,
                'joined_at' => now(),
            ]);
        }

        return $subject;
    }
}