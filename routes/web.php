<?php

use App\Http\Controllers\GuardianController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\LogsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('ManageClass');
});

Route::apiResource('students', StudentController::class)->only(['index', 'store', 'update', 'destroy']);
Route::post('students/{student}/sync-teachers', [StudentController::class, 'sync_teachers']);
Route::post('students/{student}/sync-guardians', [StudentController::class, 'sync_guardians']);

Route::apiResource('teachers', TeacherController::class)->only(['index', 'store', 'update', 'destroy']);
Route::post('teachers/{teacher}/sync-students', [TeacherController::class, 'sync_students']);

Route::apiResource('guardians', GuardianController::class)->only(['index', 'store', 'update', 'destroy']);
Route::post('guardians/{guardian}/sync-students', [GuardianController::class, 'sync_students']);

Route::get('attendance/{student_id}', [LogsController::class, 'log_time_in']);