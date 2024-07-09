<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCampusRequest;
use App\Http\Resources\CampusResource;
use App\Models\Campus;
use Cache;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $campuses = Campus::query()->with('oldestImage:url,images.imageable_id')->select(['id', 'name'])->get();

        return Inertia::render('Spaces/Campuses', [
            'campuses' => CampusResource::collection($campuses)->collection,
        ]);
    }

    public function getAll(): JsonResponse
    {
        $campuses = Campus::query()->with('images', function (Builder $query) {
            $query->select(['url'])->limit(1);
        })->select(['id', 'name'])->get();

        return response()->json($campuses);
    }

    public function getCampus(Request $request, Campus $campus): JsonResponse
    {
        $images = $request->query('images', 'all');

        $spaces = Cache::remember('campus_'.$campus->id.'_spaces', 60 * 30, function () use ($campus, $images) {
            return $campus->spaces()->with('images', function (Builder $query) use ($images) {
                $query->when($images === 'all',
                    fn (Builder $query) => $query->select(['url']),
                    fn (Builder $query) => $query->select(['url'])->limit(1)
                );
            })->get();
        });

        return response()->json($spaces);
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

        $campus->images()->createMany(
            collect($request->images)->map(fn ($image) => ['url' => Storage::url($image->store())])
        );

        return redirect(route('campuses.index'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Spaces/CreateCampus');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campus $campus): Response
    {
        $spaces = $campus->spaces()->with('oldestImage:url,images.imageable_id')->get();

        return Inertia::render('Spaces/Campus', [
            'spaces' => CampusResource::collection($spaces)->collection,
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
