<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LearningJournalController;
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
Route::put('/profile', [StudentController::class, 'updateInfo']);
Route::put('/changePassword', [StudentController::class, 'changePassword']);
Route::middleware('auth:sanctum')->get('/goals', [StudentController::class, 'getTodayGoals']);
Route::get('/teachers', [TeacherController::class, 'index']);
Route::get('/teachers/{id}', [TeacherController::class, 'show']);
Route::middleware('auth:sanctum')->post('/teachers/feedback', [TeacherController::class, 'createFeedback']);
Route::middleware('auth:teacher')->get('teachers/learning-journal/{studentId}', [LearningJournalController::class, 'getLearningJournalByStudent']);
Route::get('/teachers/learning-journals/{id}/tags', [LearningJournalController::class, 'getTagByLearningJournalId']);
