<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_start',
        'date_end',
        'space_id',
        'booking_id',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function space(): BelongsTo
    {
        return $this->belongsTo(Space::class);
    }

    protected function dateStart(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Carbon::parse($value),
        );
    }

    protected function dateEnd(): Attribute
    {

        return Attribute::make(
            get: fn ($value) => Carbon::parse($value),
        );
    }

    public function getDurationAttribute()
    {
        return $this->date_end->diffInMinutes($this->date_start);
    }
}
