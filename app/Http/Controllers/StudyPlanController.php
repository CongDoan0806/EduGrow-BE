<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StudyPlanService;

class StudyPlanController extends Controller
{
    protected $studyPlanService;

    public function __construct(StudyPlanService $studyPlanService)
    {
        $this->studyPlanService = $studyPlanService;
    }
    
    public function getTodayGoals()
    {
        $user = auth()->guard('student')->user();
        
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
        
        $goals = $this->studyPlanService->getTodayGoals($user);
        
        return response()->json($goals);
    }
}
