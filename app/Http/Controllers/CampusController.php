<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCampusRequest;
use App\Models\Campus;
use GuzzleHttp\Promise\Create;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $campuses = Campus::with('images')->get();

        return Inertia::render('Spaces/Campuses', [
            'campuses' => $campuses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Spaces/CreateCampus');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCampusRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $campus = Campus::create([
            'name' => $validated['name'],
        ]);

        $campus->name = $validated['name'];
        $campus->images()->createMany($validated['images']);

        return redirect(route('campus.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Campus $campus): Response
    {
        $spaces = $campus->spaces()->with('images', function (Builder $query) {
            $query->latest()->limit(1);
        })->get();

        return Inertia::render('Spaces/Campus', [
            'spaces' => $spaces,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campus $campus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campus $campus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campus $campus)
    {
        //
    }
}
