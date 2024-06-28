<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Requester extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'identification',
        'company_name',
        'company_role',
        'academic_unit',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
