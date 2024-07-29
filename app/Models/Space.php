<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;

class Space extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity',
        'campus_id',
    ];

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    public function resources(): BelongsToMany
    {
        return $this->belongsToMany(SpaceResource::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function oldestImage(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')->oldestOfMany();
    }

    public function timesBooked(): int
    {
        return $this->appointments()->count();
    }

    public function averageUsageTime(): float|int|null
    {
        return $this->appointments()->get()->avg(fn (Appointment $appointment) => $appointment->duration);
    }

    public function peakUsageTimes(): array
    {
        $appointments = $this->appointments()->get();

        $hoursCount = $appointments->groupBy(function ($appointment) {
            return Carbon::parse($appointment->date_start)->format('H');
        })->map(function ($hourGroup) {
            return count($hourGroup);
        });

        return $hoursCount->sortDesc()->take(3)->toArray();
    }

    public function timesBookedInTheMorning(): int
    {
        return $this->appointments()
            ->whereBetween('date_start', [now()->startOfDay(), now()->startOfDay()->addHours(12)])
            ->count();
    }

    public function timesBookedInTheAfternoon(): int
    {
        return $this->appointments()
            ->whereBetween('date_start', [now()->startOfDay()->addHours(12), now()->startOfDay()->addHours(17)])
            ->count();
    }

    public function timesBookedInTheEvening(): int
    {
        return $this->appointments()
            ->where('date_start', '>', now()->startOfDay()->addHours(17))
            ->count();
    }
}
