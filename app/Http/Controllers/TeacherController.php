<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('students')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn ($t) => [
                'id'             => $t->id,
                'first_name'     => $t->first_name,
                'middle_name'    => $t->middle_name,
                'last_name'      => $t->last_name,
                'full_name'      => $t->full_name,
                'subject'        => $t->subject,
                'contact_number' => $t->contact_number,
                'students'       => $t->students->map(fn ($s) => [
                    'id'        => $s->id,
                    'custom_id' => $s->custom_id,
                    'full_name' => $s->full_name,
                ]),
            ]);

        return response()->json($teachers);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'     => 'required|string|max:100',
            'middle_name'    => 'nullable|string|max:100',
            'last_name'      => 'required|string|max:100',
            'subject'        => 'nullable|string|max:100',
            'contact_number' => 'required|string|max:20',
        ]);

        $teacher = Teacher::create($data);

        return response()->json([
            'id'             => $teacher->id,
            'first_name'     => $teacher->first_name,
            'middle_name'    => $teacher->middle_name,
            'last_name'      => $teacher->last_name,
            'full_name'      => $teacher->full_name,
            'subject'        => $teacher->subject,
            'contact_number' => $teacher->contact_number,
            'students'       => [],
        ], 201);
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'first_name'     => 'required|string|max:100',
            'middle_name'    => 'nullable|string|max:100',
            'last_name'      => 'required|string|max:100',
            'subject'        => 'nullable|string|max:100',
            'contact_number' => 'required|string|max:20',
        ]);

        $teacher->update($data);

        return response()->json([
            'id'             => $teacher->id,
            'first_name'     => $teacher->first_name,
            'middle_name'    => $teacher->middle_name,
            'last_name'      => $teacher->last_name,
            'full_name'      => $teacher->full_name,
            'subject'        => $teacher->subject,
            'contact_number' => $teacher->contact_number,
        ]);
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return response()->json(['message' => 'Teacher deleted.']);
    }

    public function sync_students(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'integer|exists:students,id',
        ]);

        $teacher->students()->sync($data['student_ids']);

        return response()->json(['message' => 'Students updated.']);
    }
}
