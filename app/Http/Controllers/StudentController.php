<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('guardians', 'teachers')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn ($s) => [
                'id'             => $s->id,
                'custom_id'      => $s->custom_id,
                'first_name'     => $s->first_name,
                'middle_name'    => $s->middle_name,
                'last_name'      => $s->last_name,
                'full_name'      => $s->full_name,
                'contact_number' => $s->contact_number,
                'guardians'      => $s->guardians->map(fn ($g) => [
                    'id'             => $g->id,
                    'full_name'      => $g->full_name,
                    'contact_number' => $g->contact_number,
                    'email'          => $g->email,
                    'relationship'   => $g->pivot->relationship,
                ]),
                'teachers' => $s->teachers->map(fn ($t) => [
                    'id'        => $t->id,
                    'full_name' => $t->full_name,
                    'subject'   => $t->subject,
                ]),
            ]);

        return response()->json($students);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'     => 'required|string|max:100',
            'middle_name'    => 'nullable|string|max:100',
            'last_name'      => 'required|string|max:100',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $student = Student::create($data);

        return response()->json([
            'id'             => $student->id,
            'custom_id'      => $student->custom_id,
            'first_name'     => $student->first_name,
            'middle_name'    => $student->middle_name,
            'last_name'      => $student->last_name,
            'full_name'      => $student->full_name,
            'contact_number' => $student->contact_number,
            'guardians'      => [],
            'teachers'       => [],
        ], 201);
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'first_name'     => 'required|string|max:100',
            'middle_name'    => 'nullable|string|max:100',
            'last_name'      => 'required|string|max:100',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $student->update($data);

        return response()->json([
            'id'             => $student->id,
            'custom_id'      => $student->custom_id,
            'first_name'     => $student->first_name,
            'middle_name'    => $student->middle_name,
            'last_name'      => $student->last_name,
            'full_name'      => $student->full_name,
            'contact_number' => $student->contact_number,
        ]);
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json(['message' => 'Student deleted.']);
    }

    public function sync_teachers(Request $request, Student $student)
    {
        $data = $request->validate([
            'teacher_ids' => 'required|array',
            'teacher_ids.*' => 'integer|exists:teachers,id',
        ]);

        $student->teachers()->sync($data['teacher_ids']);

        return response()->json(['message' => 'Teachers updated.']);
    }

    public function sync_guardians(Request $request, Student $student)
    {
        $data = $request->validate([
            'guardians'                => 'required|array',
            'guardians.*.id'           => 'required|integer|exists:guardians,id',
            'guardians.*.relationship' => 'nullable|string|max:50',
        ]);

        $sync = collect($data['guardians'])->mapWithKeys(fn ($g) => [
            $g['id'] => ['relationship' => $g['relationship'] ?? null],
        ])->all();

        $student->guardians()->sync($sync);

        return response()->json(['message' => 'Guardians updated.']);
    }
}
