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

        $roles = Role::where('name', '!=', AppRoles::DEVELOPER)->get(['name']);

        return Inertia::render('Team/Index', [
            'roles' => $roles,
            'users' => User::withoutRole([AppRoles::REQUESTER, AppRoles::DEVELOPER])->with('roles:name')->select(['id', 'name', 'email'])->get(),
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

    public function removeFromTeam(User $user)
    {
        if (auth()->user()->cannot(TeamPermissions::REMOVE_MEMBER->value)) {
            return \response()->json([
                'message' => 'You are not authorized to remove members',
            ], 403);
        }

        if ($user->hasRole(AppRoles::DEVELOPER)) {
            return \response()->json([
                'message' => 'You cannot remove a developer',
            ], 403);
        }

        $user->syncRoles([AppRoles::REQUESTER]);

        return \response()->json([
            'message' => 'User removed successfully',
        ]);
    }
}
