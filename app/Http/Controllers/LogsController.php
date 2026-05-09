<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function log_time_in($student_id)
    {
        dd(Student::where('custom_id', $student_id)->with('guardians')->first()->toArray());
    }
}
