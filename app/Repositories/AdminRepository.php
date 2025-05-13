<?php
namespace App\Repositories;
use App\Models\Student;
class AdminRepository{
    public function getAll(){
        return Student::all();
    }
}