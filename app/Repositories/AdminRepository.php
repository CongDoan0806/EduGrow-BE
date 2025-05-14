<?php
namespace App\Repositories;
use App\Models\Student;
use App\Models\Teacher;
class AdminRepository{
    public function getAll(){
        return Student::all();
    }
    public function getAllTeacher(){
        return Teacher::all();
    }
}