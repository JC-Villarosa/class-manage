<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Guardian;

class MainController extends Controller
{
    public function index()
    {
        // dump(Teacher::all()->toArray());
        return Inertia::render('ManageClass' , [
            'students'  => Student::with('guardians', 'teachers')->get(),
            'teachers'  => Teacher::all(),
            'guardians' => Guardian::all(),
        ]);
    }
}
