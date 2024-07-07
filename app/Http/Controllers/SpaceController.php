<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSpaceRequest;
use App\Models\Space;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class SpaceController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(string $campus): Response
    {
        return Inertia::render('Spaces/CreateSpace', [
            'campus' => $campus,
        ]);
    }

    public function getSpace(Space $space): JsonResponse
    {
        return response()->json($space->load('resources', 'images'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSpaceRequest $request): RedirectResponse
    {
        $space = Space::create($request->validated());

        $space->resources()->createMany(
            collect($request->resources)->map(fn ($resource) => ['resource_id' => $resource])->toArray()
        );

        $space->images()->createMany(
            collect($request->images)->map(fn ($image) => ['url' => Storage::url($image->store())])->toArray()
        );

        return redirect()->route('campuses.show', $space->campus_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Space $space): Response
    {
        return Inertia::render('Spaces/Space', [
            'space' => $space->load('resources', 'images'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Space $space)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Space $space)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Space $space)
    {
        //
    }
}
