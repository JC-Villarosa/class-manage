<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\GuardianController;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Guardian;

Route::get('/', function () {
    return Inertia::render('ManageClass' , [
        'students'  => Student::all(),
        'teachers'  => Teacher::all(),
        'guardians' => Guardian::all(),
    ]);
});

Route::post('/students',  [StudentController::class,  'store']);
Route::post('/teachers',  [TeacherController::class,  'store']);
Route::post('/guardians', [GuardianController::class, 'store']);
