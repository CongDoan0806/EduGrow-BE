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
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/admin/dashboard', [AdminController::class, 'getStats']);
Route::middleware('auth:sanctum')->get('/admin/teacher',[AdminController::class, 'showListTeacher']);
Route::middleware('auth:sanctum')->get('/admin/student',[AdminController::class, 'showListStudent']);
Route::middleware('auth:sanctum')->post('/Add-user', [AdminController::class, 'add']);

Route::middleware('auth:sanctum')->post('/admin/add-class', [AdminController::class, 'addClass']);
Route::middleware('auth:sanctum')->get('/goals', [StudentController::class, 'getTodayGoals']);
Route::get('/teachers', [TeacherController::class, 'index']);
Route::get('/teachers/{id}', [TeacherController::class, 'show']);
Route::middleware('auth:sanctum')->get('/teachers/student-goal/{studentId}', [SemesterGoalController::class, 'getSemesterGoalsByStudentId']);
Route::middleware('auth:teacher')->put('teachers/student-goal/{goalId}/deadline', [SemesterGoalController::class, 'setDeadlineByGoalId']);
Route::middleware('auth:teacher')->put('teachers/student-goal/{goalId}/feedback', [SemesterGoalController::class, 'setFeedbackByGoalId']);
Route::middleware('auth:sanctum')->get('/admin/class',[AdminController::class, 'getAllClasses']);

Route::middleware('auth:sanctum')->get('/learning-journal', [StudentController::class, 'getLearningJournal']);
Route::middleware('auth:sanctum')->post('/learning-journal', [StudentController::class, 'saveLearningJournal']);
Route::get('/learning-journal/week/{weekNumber}', [StudentController::class, 'getWeekDates']);

Route::middleware('auth:sanctum')->post('/teachers/feedback', [TeacherController::class, 'createFeedback']);
Route::middleware('auth:teacher')->get('teachers/learning-journal/{studentId}', [LearningJournalController::class, 'getLearningJournalByStudent']);
Route::middleware('auth:teacher')->get('/teachers/learning-journals/{id}/tags', [LearningJournalController::class, 'getTagByLearningJournalId']);
Route::get('/student/subjects', [StudentController::class, 'showSubjects']);

Route::middleware('auth:student')->group(function () {
    Route::get('/study-plans', [StudentController::class, 'getStudyPlans']);
    Route::post('/study-plans', [StudentController::class, 'addStudyPlan']);
    Route::delete('/study-plans/{id}', [StudentController::class, 'deleteStudyPlan']);
    Route::get('/profile', [StudentController::class, 'showInfo']);
    Route::put('/profile/text', [StudentController::class, 'updateTextInfo']);
    Route::post('/profile/avatar', [StudentController::class, 'uploadAvatar']);
    Route::put('/changePassword', [StudentController::class, 'changePassword']);
    // Routes mới cho Semester Goal
    Route::get('/semester-goals', [SemesterGoalController::class, 'getSemesterGoals']);
    Route::post('/semester-goals', [SemesterGoalController::class, 'createSemesterGoal']);
    Route::put('/semester-goals/content/{goalId}', [SemesterGoalController::class, 'updateGoalContent']);
    Route::post('/semester-goals/content', [SemesterGoalController::class, 'addGoalContent']); // Thêm route mới
    Route::get('/subjects', [SemesterGoalController::class, 'getSubjects']);

    Route::middleware('auth:sanctum')->get('/learning-journal', [StudentController::class, 'getLearningJournal']);
    Route::middleware('auth:sanctum')->post('/learning-journal', [StudentController::class, 'saveLearningJournal']);
    Route::get('/learning-journal/week/{weekNumber}', [StudentController::class, 'getWeekDates']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tag/subjects-comments', [StudentController::class, 'getSubjectsAndComments']);
    Route::post('/tags', [StudentController::class, 'store']);
    Route::get('/tag/teachers', [StudentController::class, 'getTeachersBySubject']);
    
});
// routes/api.php

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/teacher/tags', [TeacherController::class, 'getTags']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/Add-user', [AdminController::class, 'add']);
    Route::get('/admin/student', [AdminController::class, 'showListStudent']);
    Route::get('/admin/teacher', [AdminController::class, 'showListTeacher']);
    Route::put('/update-user/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/delete-user/{id}', [AdminController::class, 'deleteUser']);
});

Route::middleware(['auth:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard']);
    Route::get('/teacher/classes', [TeacherController::class, 'getTeacherClasses']);
});