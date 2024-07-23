<?php

namespace App\Http\Controllers;

use App\Models\InterestedParty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InterestedPartyController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        InterestedParty::create($validated);

        Log::info('Interested party created', [
            'email' => $validated['email'],
            'by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Interested party created');
    }
}
