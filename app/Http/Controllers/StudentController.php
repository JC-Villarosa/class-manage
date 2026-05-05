<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'      => 'required|string|max:100',
            'middle_name'     => 'nullable|string|max:100',
            'last_name'       => 'required|string|max:100',
            'contact_number'  => 'nullable|string|max:20',
            'guardian_ids'    => 'nullable|array',
            'guardian_ids.*'  => 'exists:guardians,id',
            'relationships'   => 'nullable|array',
            'relationships.*' => 'nullable|string|max:50',
            'teacher_ids'     => 'nullable|array',
            'teacher_ids.*'   => 'exists:teachers,id',
        ]);

        $student = Student::create(
            collect($validated)
                ->except(['guardian_ids', 'relationships', 'teacher_ids'])
                ->toArray()
        );

        if (!empty($validated['guardian_ids'])) {
            $pivot = [];
            foreach ($validated['guardian_ids'] as $index => $guardian_id) {
                $pivot[$guardian_id] = [
                    'relationship' => $validated['relationships'][$index] ?? null,
                ];
            }
            $student->guardians()->attach($pivot);
        }

        if (!empty($validated['teacher_ids'])) {
            $student->teachers()->attach($validated['teacher_ids']);
        }

        return redirect()->back();
    }
}