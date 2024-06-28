<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'type',
        'size',
    ];

    public function space(): BelongsToMany
    {
        return $this->belongsToMany(Space::class,);
    }

    public function campus(): BelongsToMany
    {
        return $this->belongsToMany(Campus::class,);
    }

    public function booking(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class,);
    }
}
