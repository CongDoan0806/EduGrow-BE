<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ClassGroupSeeder::class,
            StudentSeeder::class,
            AdminSeeder::class,
            TeacherSeeder::class,
            SubjectSeeder::class,
            StudentSubjectSeeder::class,
            LearningJournalSeeder::class,
            LearningJournalClassSeeder::class,
            LearningJournalSelfSeeder::class,
            StudyPlanSeeder::class,
            SemesterGoalSeeder::class,
            SemesterGoalContentSeeder::class,
            NotificationSeeder::class,

        ]);
    }
}
