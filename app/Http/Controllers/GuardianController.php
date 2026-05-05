<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use Illuminate\Http\Request;

class GuardianController extends Controller
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

        Guardian::create($validated);

        return redirect()->back();
    }
}