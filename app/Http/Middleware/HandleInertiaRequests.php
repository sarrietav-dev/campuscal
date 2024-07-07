<?php

namespace App\Http\Middleware;

use App\Authorization\TeamPermissions;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
            ],
            'can' => [
                'viewTeam' => $request->user() ? $request->user()->can(TeamPermissions::VIEW_TEAM->value) : null,
            ],
            'auth' => [
                'user' => $request->user(),
            ],
        ];
    }
}
