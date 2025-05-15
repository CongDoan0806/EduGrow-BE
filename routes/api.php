<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/admin/teacher',[AdminController::class, 'showListTeacher']);
Route::middleware('auth:sanctum')->get('/admin/student',[AdminController::class, 'showListStudent']);
Route::put('/profile', [StudentController::class, 'updateInfo']);
Route::put('/changePassword', [StudentController::class, 'changePassword']);
Route::middleware('auth:sanctum')->post('/Add-user', [AdminController::class, 'add']);

