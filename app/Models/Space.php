<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

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
        return $this->appointments()
            ->selectRaw('HOUR(date_start) as hour, count(*) as count')
            ->groupBy('hour')
            ->orderBy('count', 'desc')
            ->limit(3)
            ->get()
            ->toArray();
    }

    public function timesBookedInTheMorning(): int
    {
        return $this->appointments()
            ->whereRaw('HOUR(date_start) < 12')
            ->count();
    }

    public function timesBookedInTheAfternoon(): int
    {
        return $this->appointments()
            ->whereRaw('HOUR(date_start) <= 17 AND HOUR(date_start) >= 12')
            ->count();
    }

    public function timesBookedInTheEvening(): int
    {
        return $this->appointments()
            ->whereRaw('HOUR(date_start) > 17')
            ->count();
    }
}
