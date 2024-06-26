<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    public function requester(): HasOne
    {
        return $this->hasOne(Requester::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function audience(): HasMany
    {
        return $this->hasMany(Audience::class);
    }

    public function agreementContracts(): BelongsToMany
    {
        return $this->belongsToMany(File::class);
    }
}