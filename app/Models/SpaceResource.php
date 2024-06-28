<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SpaceResource extends Model
{
    use HasFactory;

    public function spaces(): BelongsToMany
    {
        return $this->belongsToMany(Space::class);
    }
}
