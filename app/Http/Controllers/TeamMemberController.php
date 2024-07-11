<?php

namespace App\Http\Controllers;

use App\Authorization\AppRoles;
use App\Authorization\TeamPermissions;
use App\Events\UserInvited;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->cannot(TeamPermissions::VIEW_TEAM->value)) {
            return redirect()->route('dashboard');
        }

        $roles = Role::where('name', '!=', AppRoles::DEVELOPER)->get(['name']);

        return Inertia::render('Team/Index', [
            'roles' => $roles,
            'users' => User::withoutRole([AppRoles::REQUESTER, AppRoles::DEVELOPER])
                ->whereNotNull('email_verified_at')
                ->with('roles:name')
                ->select(['id', 'name', 'email'])
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->cannot(TeamPermissions::INVITE_MEMBER->value)) {
            return redirect()->back()->withErrors([
                'message' => __('You are not authorized to invite members'),
            ], 403);
        }

        $validated = $request->validate([
            'email' => ['required', 'email'],
            'role' => ['required', 'exists:Spatie\Permission\Models\Role,name'],
        ]);

        UserInvited::dispatch($validated['email'], $validated['role']);

        return redirect()->back()->with('message', __('User invited successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
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
}
