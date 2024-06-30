<?php

namespace App\Services;

use App\Models\Space;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class SpaceStatisticsService
{
    public function getMostRequestedSpaces()
    {
        return Cache::remember('most_requested_spaces', 60, function () {
            return Space::withCount('appointments')
                ->whereMonth('created_at', now()->month)
                ->orderBy('appointments_count', 'desc')
                ->limit(5)
                ->with('images', function (Builder $query) {
                    $query->latest()->limit(1)->select('path');
                })
                ->get();
        });
    }
}
