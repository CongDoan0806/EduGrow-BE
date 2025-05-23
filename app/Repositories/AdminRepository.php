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

    public function countActiveClasses(): array
    {
        $today = Carbon::today();

        $activeCount = Subject::where('end_date', '>=', $today)->distinct('class_id')->count('class_id');
        $inactiveCount = Subject::where('end_date', '<', $today)->distinct('class_id')->count('class_id');

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
}