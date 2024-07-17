<?php

namespace App\Http\Controllers;

use App\Models\InterestedParty;
use Illuminate\Http\Request;

class InterestedPartyController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        InterestedParty::create($validated);

        return redirect()->back()->with('success', 'Interested party created');
    }
}
