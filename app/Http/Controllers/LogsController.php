<?php

namespace App\Http\Controllers;

use App\Mail\NotifyGuardian;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LogsController extends Controller
{
    public function log_time_in($student_id)
    {
        // dd(Student::where('custom_id', $student_id)->with('guardians')->first()->toArray());
        $record = Student::where('custom_id', $student_id)->with('guardians')->first();

        if ($record->guardians)
        {
            foreach($record->guardians as $guardian)
            {
                Mail::to($guardian->email)->send(new NotifyGuardian($record));
            }
        }
    }
}
