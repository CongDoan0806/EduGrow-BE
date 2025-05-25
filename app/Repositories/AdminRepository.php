<?php
namespace App\Repositories;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassGroup;
use App\Models\Tag;
use App\Models\TagReplies;
use App\Models\Subject;
use GuzzleHttp\Psr7\Request;
use Carbon\Carbon;
use App\Models\StudentSubject;
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

    public function countTeachers(): int
    {
        return Teacher::count();
    }

    public function countStudents(): int
    {
        return Student::count();
    }

    public function countActiveAccounts(string $period): int
    {
        $date = match ($period) {
            'day' => Carbon::now()->subDay(),
            'week' => Carbon::now()->subWeek(),
            'month' => Carbon::now()->subMonth(),
            default => Carbon::now()->subDay(),
        };

        $studentCount = Student::where('updated_at', '>=', $date)->count();
        $teacherCount = Teacher::where('updated_at', '>=', $date)->count();

        return $studentCount + $teacherCount;
    }

    public function countClassGroups(): int
    {
        return ClassGroup::distinct('class_id')->count('class_id');
    }

    public function countActiveSubjects(): array
    {
        $today = Carbon::today();

        $activeCount = Subject::where('end_date', '>=', $today)->count();
        $inactiveCount = Subject::where('end_date', '<', $today)->count();

        return [
            ['status' => 'Active', 'count' => $activeCount],
            ['status' => 'Inactive', 'count' => $inactiveCount],
        ];
    }

     public function getStudentsPerClass(): array
    {
        return ClassGroup::withCount('student')  
            ->get(['class_id', 'class_name', 'student_count']) 
            ->map(function ($classGroup) {
                return [
                    'class_id' => $classGroup->class_id,
                    'class_name' => $classGroup->class_name,
                    'student_count' => $classGroup->student_count, 
                ];
            })
            ->toArray();
    }

    public function getWeeklyTagCounts(): array
    {
        return Tag::selectRaw("WEEK(created_at) as week_number, COUNT(*) as tag_count")
            ->groupBy('week_number')
            ->orderBy('week_number')
            ->get()
            ->toArray();
    }

    public function getDailyReplyCountsFromTeachers(): array
    {
        return TagReplies::selectRaw("DATE(created_at) as reply_date, COUNT(*) as reply_count")
            ->groupBy('reply_date')
            ->orderBy('reply_date')
            ->get()
            ->toArray();
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

    public function getAllClasses()
    {
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