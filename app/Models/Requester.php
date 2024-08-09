<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Requester extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }
}
