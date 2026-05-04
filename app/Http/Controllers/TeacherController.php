<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'     => 'required|string|max:100',
            'middle_name'    => 'nullable|string|max:100',
            'last_name'      => 'required|string|max:100',
            'contact_number' => 'required|string|max:20',
            'address'        => 'nullable|string',
        ]);

        Teacher::create($validated);

        return redirect()->back();
    }
}