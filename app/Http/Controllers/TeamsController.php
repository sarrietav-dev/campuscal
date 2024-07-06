<?php

namespace App\Http\Controllers;

use App\Authorization\AppRoles;
use App\Authorization\TeamPermissions;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class TeamsController extends Controller
{
    public function index()
    {
        if (auth()->user()->cannot(TeamPermissions::VIEW_TEAM->value)) {
            return redirect()->route('dashboard');
        }

        $roles = Role::query()->select(['name'])->get();

        return Inertia::render('Team/Index', [
            'roles' => $roles,
            'users' => User::withoutRole(AppRoles::REQUESTER)->with('roles:name')->select(['id', 'name', 'email'])->get(),
        ]);
    }

    public function invite(Request $request)
    {
        if (auth()->user()->cannot(TeamPermissions::INVITE_MEMBER->value)) {
            return \response()->json([
                'message' => 'You are not authorized to invite members',
            ], 403);
        }

        $validated = $request->validate([
            'email' => ['required', 'email'],
            'role' => ['required', 'exists:Spatie\Permission\Models\Role,name'],
        ]);

        $tempUser = User::create([
            'email' => $validated['email'],
        ]);

        $tempUser->syncRoles([$validated['role']]);

        return \response()->json([
            'message' => 'User invited successfully',
        ]);
    }

    public function remove(Request $request)
    {
        if (auth()->user()->cannot(TeamPermissions::REMOVE_MEMBER->value)) {
            return \response()->json([
                'message' => 'You are not authorized to remove members',
            ], 403);
        }

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $user = User::find($validated['user_id']);

        $user->delete();

        return \response()->json([
            'message' => 'User removed successfully',
        ]);
    }
}
