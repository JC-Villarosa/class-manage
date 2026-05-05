<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\GuardianController;

Route::get('/',  [MainController::class,  'index']);
Route::post('/students',  [StudentController::class,  'store']);
Route::post('/teachers',  [TeacherController::class,  'store']);
Route::post('/guardians', [GuardianController::class, 'store']);
