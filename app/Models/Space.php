<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\DB;

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

    private function hourExpresion()
    {
        $hourExpression = DB::getDriverName() === 'sqlite'
            ? "CAST(strftime('%H', date_start) AS INTEGER)"
            : 'HOUR(date_start)';

        return $hourExpression;
    }

    /**
     * Return the top 3 most used hours
     */
    public function peakUsageTimes(): array
    {
        return $this->appointments()
            ->selectRaw($this->hourExpresion().' as hour, count(*) as count')
            ->groupBy('hour')
            ->orderByDesc('count')
            ->limit(3)
            ->get()
            ->map(fn ($item) => [
                'hour' => $item->hour,
                'count' => $item->count,
            ])
            ->toArray();
    }

    public function timesBookedInTheMorning(): int
    {
        return $this->appointments()
            ->whereRaw($this->hourExpresion().' < 12')
            ->count();
    }

    public function timesBookedInTheAfternoon(): int
    {
        return $this->appointments()
            ->whereRaw($this->hourExpresion().' >= 12')
            ->whereRaw($this->hourExpresion().' < 18')
            ->count();
    }

    public function timesBookedInTheEvening(): int
    {
        return $this->appointments()
            ->whereRaw($this->hourExpresion().' >= 18')
            ->count();
    }
}
