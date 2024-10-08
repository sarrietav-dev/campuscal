<?php

namespace App\Http\Controllers\Auth;

use App\Authorization\AppRoles;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['exists:Spatie\Permission\Models\Role,name'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($validated['role'] ?? false) {
            $user->assignRole(AppRoles::from($validated['role']));
            $user->markEmailAsVerified();
        } else {
            $user->assignRole(AppRoles::REQUESTER);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('verification.notice', absolute: false));
    }

    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        $googleConfig = config('services.google');

        return Inertia::render('Auth/Register', [
            'isSignInWithGoogleEnabled' => $googleConfig['client_id'] && $googleConfig['client_secret'] && $googleConfig['redirect'],
        ]);
    }
}
