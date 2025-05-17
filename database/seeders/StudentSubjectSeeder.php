<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSubjectSeeder extends Seeder
{
    public function run()
    {
        DB::table('student_subject')->insert([
            [
                'student_id' => 1,  
                'subject_id' => 1, 
                'joined_at' => now(),  
                'created_at' => now(), 
            ],
            [
                'student_id' => 1,  
                'subject_id' => 2, 
                'joined_at' => now(),
                'created_at' => now(),
            ],
            [
                'student_id' => 2,  
                'subject_id' => 1, 
                'joined_at' => now(),
                'created_at' => now(),
            ],
            [
                'student_id' => 2,  
                'subject_id' => 2, 
                'joined_at' => now(),
                'created_at' => now(),
            ],
            [
                'student_id' => 2,  
                'subject_id' => 3, 
                'joined_at' => now(),
                'created_at' => now(),
            ],
        ]);
    }
}

