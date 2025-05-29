<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SemesterGoalContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('semester_goal_contents')->insert([
            [
                'goal_id' => 1,
                'content' => 'Complete all assignments on time',
                'reward' => 'A day off',
                'status' => 'failed',
                'reflect' => "Haven't tried my best",
                'sg_id' => 1,
            ],
            [
                'goal_id' => 2,
                'content' => 'Improve quiz scores by 10%',
                'reward' => 'Movie tickets',
                'status' => 'completed',
                'reflect' => 'Need to study more',
                'sg_id' => 2,
            ],
            [
                'goal_id' => 3,
                'content' => 'Participate in group discussions',
                'reward' => null,
                'status' => 'completed',
                'reflect' => 'Learned a lot from classmates',
                'sg_id' => 3,
            ],
            [
                'goal_id' => 4,
                'content' => 'Improve quiz scores by 50%',
                'reward' => 'New book',
                'status' => 'pending',
                'reflect' => null,
                'sg_id' => 2,
            ],
            [
                'goal_id' => 5,
                'content' => 'Improve reading skill',
                'reward' => 'New House',
                'status' => 'pending',
                'reflect' => null,
                'sg_id' => 4,
            ],
            [
                'goal_id' => 6,
                'content' => 'Complete all assignments on time',
                'reward' => 'None',
                'status' => 'completed',
                'reflect' => 'Hẹ hẹ',
                'sg_id' => 4,
            ],
            [
                'goal_id' => 7,
                'content' => 'Complete all assignments',
                'reward' => 'New book',
                'status' => 'pending',
                'reflect' => null,
                'sg_id' => 4,
            ],
            [
                'goal_id' => 8,
                'content' => 'I expect myself to proactive and confident communicating with my classmates more often.',
                'reward' => 'Travel to Quang Binh province',
                'status' => 'completed',
                'reflect' => 'Very good',
                'sg_id' => 5,
            ],
            [
                'goal_id' => 9,
                'content' => 'Get 9 points',
                'reward' => 'New book',
                'status' => 'completed',
                'reflect' => 'Very good hẹ hẹ hẹhẹ',
                'sg_id' => 1,
            ],
            [
                'goal_id' => 10,
                'content' => 'Speaking influence',
                'reward' => 'Travel to Quang Binh province',
                'status' => 'pending',
                'reflect' => null,
                'sg_id' => 1,
            ],
            [
                'goal_id' => 11,
                'content' => 'Completed all task on time',
                'reward' => 'New House',
                'status' => 'pending',
                'reflect' => null,
                'sg_id' => 5,
            ],
        ]);
    }
}
