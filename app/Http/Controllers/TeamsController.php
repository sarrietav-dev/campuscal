<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeamsController extends Controller
{
    public function index()
    {
        $roles = Role::query()->select(['display_name', 'id', 'name'])->get();

        return Inertia::render('Team/Index', [
            'roles' => $roles,
        ]);
    }

    public function invite(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'role' => 'required|exists:App\Models\Role,name',
        ]);

        $tempUser = User::create([
            'email' => $validated['email'],
        ]);

        $tempUser->assignRole($validated['role']);

        return \response()->json([
            'message' => 'User invited successfully',
        ]);
    }
}
