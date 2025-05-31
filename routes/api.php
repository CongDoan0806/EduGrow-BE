<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LearningJournalController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SemesterGoalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'getStats']);
    Route::post('/users', [AdminController::class, 'add']);
    Route::put('/users/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
    Route::get('/teachers', [AdminController::class, 'showListTeacher']);
    Route::get('/students', [AdminController::class, 'showListStudent']);
    Route::get('/classes', [AdminController::class, 'getAllClasses']);
    Route::post('/classes', [AdminController::class, 'addClass']);
});

Route::middleware(['auth:sanctum'])->prefix('teacher')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard']);
    Route::get('/classes', [TeacherController::class, 'getTeacherClasses']);
    Route::get('/subjects', [TeacherController::class, 'getSubjects']);
    Route::get('/students-by-subject', [TeacherController::class, 'getStudentsBySubject']);
    Route::post('/feedback', [TeacherController::class, 'createFeedback']);
    Route::get('/tags', [TeacherController::class, 'getTags']);
    Route::get('/students/{studentId}/semester-goals', [SemesterGoalController::class, 'getSemesterGoalsByStudentId']);
    Route::put('/semester-goals/{goalId}/deadline', [SemesterGoalController::class, 'setDeadlineByGoalId']);
    Route::put('/semester-goals/{goalId}/feedback', [SemesterGoalController::class, 'setFeedbackByGoalId']);
    Route::get('/students/{studentId}/learning-journals', [LearningJournalController::class, 'getLearningJournalByStudent']);
    Route::get('/learning-journals/{id}/tags', [LearningJournalController::class, 'getTagByLearningJournalId']);
    Route::get('/', [TeacherController::class, 'index']);//
    Route::get('/teachers/{id}', [TeacherController::class, 'show']); //
});

Route::middleware(['auth:sanctum'])->prefix('students')->group(function () {
    Route::get('/profile', [StudentController::class, 'showInfo']);
    Route::put('/profile/info', [StudentController::class, 'updateTextInfo']);
    Route::post('/profile/avatar', [StudentController::class, 'uploadAvatar']);
    Route::put('/profile/password', [StudentController::class, 'changePassword']);
    Route::get('/study-plans', [StudentController::class, 'getStudyPlans']);
    Route::post('/study-plans', [StudentController::class, 'addStudyPlan']);
    Route::delete('/study-plans/{id}', [StudentController::class, 'deleteStudyPlan']);
    Route::get('/goals/today', [StudentController::class, 'getTodayGoals']);
    Route::get('/semester-goals', [SemesterGoalController::class, 'getSemesterGoals']);
    Route::post('/semester-goals', [SemesterGoalController::class, 'createSemesterGoal']);
    Route::put('/semester-goals/content/{goalId}', [SemesterGoalController::class, 'updateGoalContent']);
    Route::post('/semester-goals/content', [SemesterGoalController::class, 'addGoalContent']);
    Route::get('/achievements', [StudentController::class, 'getAchievements']);
    Route::post('/achievements', [StudentController::class, 'uploadAchievement']);
    Route::get('/learning-journals', [StudentController::class, 'getLearningJournal']);
    Route::post('/learning-journals', [StudentController::class, 'saveLearningJournal']);
    Route::get('/subjects', [StudentController::class, 'showSubjects']);//
    Route::get('/semester/subjects', [SemesterGoalController::class, 'getSubjects']); //
    Route::get('/learning-journal/week/{weekNumber}', [StudentController::class, 'getWeekDates']);//
    Route::get('/tag/subjects-comments', [StudentController::class, 'getSubjectsAndComments']);//
    Route::post('/tags', [StudentController::class, 'store']);
    Route::get('/tag/teachers', [StudentController::class, 'getTeachersBySubject']);
});