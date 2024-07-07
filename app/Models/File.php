<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'type',
        'size',
    ];

    public function booking(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class);
    }
}
