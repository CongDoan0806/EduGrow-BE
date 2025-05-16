<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudyPlanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/goals', [StudentController::class, 'getTodayGoals']);
Route::get('/teachers', [TeacherController::class, 'index']);
Route::get('/teachers/{id}', [TeacherController::class, 'show']);
Route::get('/student/subjects', [StudentController::class, 'showSubjects']);
Route::middleware('auth:student')->group(function () {
    Route::get('/study-plans', [StudentController::class, 'getStudyPlans']);
    Route::post('/study-plans', [StudentController::class, 'addStudyPlan']);
    Route::delete('/study-plans/{id}', [StudentController::class, 'deleteStudyPlan']);
    Route::get('/profile', [StudentController::class, 'showInfo']);
    Route::put('/profile', [StudentController::class, 'updateInfo']);
    Route::put('/changePassword', [StudentController::class, 'changePassword']);
});

