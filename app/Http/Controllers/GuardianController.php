<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    public function index()
    {
        $guardians = Guardian::with('students')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn ($g) => [
                'id'             => $g->id,
                'first_name'     => $g->first_name,
                'middle_name'    => $g->middle_name,
                'last_name'      => $g->last_name,
                'full_name'      => $g->full_name,
                'contact_number' => $g->contact_number,
                'email'          => $g->email,
                'students'       => $g->students->map(fn ($s) => [
                    'id'           => $s->id,
                    'custom_id'    => $s->custom_id,
                    'full_name'    => $s->full_name,
                    'relationship' => $s->pivot->relationship,
                ]),
            ]);

        return response()->json($guardians);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'     => 'required|string|max:100',
            'middle_name'    => 'nullable|string|max:100',
            'last_name'      => 'required|string|max:100',
            'contact_number' => 'required|string|max:20',
            'email'          => 'nullable|email|max:100',
        ]);

        $guardian = Guardian::create($data);

        return response()->json([
            'id'             => $guardian->id,
            'first_name'     => $guardian->first_name,
            'middle_name'    => $guardian->middle_name,
            'last_name'      => $guardian->last_name,
            'full_name'      => $guardian->full_name,
            'contact_number' => $guardian->contact_number,
            'email'          => $guardian->email,
            'students'       => [],
        ], 201);
    }

    public function update(Request $request, Guardian $guardian)
    {
        $data = $request->validate([
            'first_name'     => 'required|string|max:100',
            'middle_name'    => 'nullable|string|max:100',
            'last_name'      => 'required|string|max:100',
            'contact_number' => 'required|string|max:20',
            'email'          => 'nullable|email|max:100',
        ]);

        $guardian->update($data);

        return response()->json([
            'id'             => $guardian->id,
            'first_name'     => $guardian->first_name,
            'middle_name'    => $guardian->middle_name,
            'last_name'      => $guardian->last_name,
            'full_name'      => $guardian->full_name,
            'contact_number' => $guardian->contact_number,
            'email'          => $guardian->email,
        ]);
    }

    public function destroy(Guardian $guardian)
    {
        $guardian->delete();

        return response()->json(['message' => 'Guardian deleted.']);
    }

    public function sync_students(Request $request, Guardian $guardian)
    {
        $data = $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'integer|exists:students,id',
        ]);

        $guardian->students()->sync($data['student_ids']);

        return response()->json(['message' => 'Students updated.']);
    }
}
