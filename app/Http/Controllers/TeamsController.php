<?php

namespace App\Http\Controllers;

use App\Authorization\AppRoles;
use App\Authorization\TeamPermissions;
use App\Events\UserInvited;
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
            return \redirect()->back()->withErrors([
                'message' => __('You are not authorized to invite members'),
            ], 403);
        }

        $validated = $request->validate([
            'email' => ['required', 'email'],
            'role' => ['required', 'exists:Spatie\Permission\Models\Role,name'],
        ]);

        $tempUser = User::create([
            'name' => "",
            'email' => $validated['email'],
        ]);

        $tempUser->syncRoles([$validated['role']]);

        UserInvited::dispatch($tempUser);

        return \response()->json([
            'message' => __('User invited successfully'),
        ]);
    }

    public function removeFromTeam(User $user)
    {
        if (auth()->user()->cannot(TeamPermissions::REMOVE_MEMBER->value)) {
            return redirect()->back()->withErrors([
                'message' => __('You are not authorized to remove members'),
            ], 403);
        }

        if ($user->hasRole(AppRoles::DEVELOPER)) {
            return redirect()->back()->withErrors([
                'message' => __('You cannot remove developers from the team'),
            ], 403);
        }

        $user->syncRoles([AppRoles::REQUESTER]);

        return redirect()->back()->with('message', __('User removed from the team successfully'));
    }

    public function updateRole(Request $request, User $user)
    {
        if (auth()->user()->cannot(TeamPermissions::UPDATE_ROLE->value)) {
            return redirect()->back()->withErrors([
                'message' => __('You are not authorized to update user roles'),
            ], 403);
        }

        $validated = $request->validate([
            'role' => ['required', 'exists:Spatie\Permission\Models\Role,name'],
        ]);

        $user->syncRoles([$validated['role']]);

        return redirect()->back()->with('message', __('User role updated successfully'));
    }
}
